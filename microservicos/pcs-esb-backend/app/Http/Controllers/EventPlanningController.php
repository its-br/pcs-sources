<?php

namespace App\Http\Controllers;

use App\Models\EventPlanning;
use App\Models\Voyage;
use App\Models\EventPlanningStatus;
use Illuminate\Http\Request;
use App\Http\Resources\EventPlanningResource;
use Illuminate\Support\Facades\Log;

class EventPlanningController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Voyage  $voyage
     * @return \Illuminate\Http\Response
     */
    public function index(Voyage $voyage)
    {
        return EventPlanningResource::collection($voyage->event_plannings);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Voyage  $voyage
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Voyage $voyage)
    {
        $event_planning = new EventPlanning;

        $event_planning->transport_call_id = $request->transportCallID;
        $event_planning->event_created_date_time = str_replace('Z', '', $request->eventCreatedDateTime);
        $event_planning->event_time = str_replace('Z', '', $request->eventTime);
        $event_planning->event_type = $request->eventType;
        $event_planning->transport_event_type_code = $request->transportEventTypeCode;
        $event_planning->operations_event_type_code = $request->operationsEventTypeCode;
        $event_planning->event_classifier_code = $request->eventClassifierCode;

        $voyage->event_plannings()->save($event_planning);

        // TODO: refatorar o metodo para criar apenas 1 horario planejado para cada evento com menos consultas
        // PLN events

        $event_types = ['STRT', 'CMPL'];
        $transport_event_type_codes = ['EST', 'REQ', 'PLN', 'ACT'];
        $operations_event_type_codes = ['TRANSPORT', 'PILOTTIME', 'OPERATION'];
        $event_classifier_codes = ['ARRI', 'DEPA'];

        foreach ($event_types as $event_type) {
            foreach ($operations_event_type_codes as $operations_event_type_code) {
                foreach ($event_classifier_codes as $event_classifier_code) {
                    $est = EventPlanning::where('voyage_id', $voyage->id)
                                            ->where('event_type', $event_type)
                                            ->where('transport_call_id', $request->transportCallID)
                                            ->where('transport_event_type_code', 'EST')
                                            ->where('operations_event_type_code', $operations_event_type_code)
                                            ->where('event_classifier_code', $event_classifier_code)
                                            ->latest()
                                            ->first();
                    $req = EventPlanning::where('voyage_id', $voyage->id)
                                            ->where('event_type', $event_type)
                                            ->where('transport_call_id', $request->transportCallID)
                                            ->where('transport_event_type_code', 'REQ')
                                            ->where('operations_event_type_code', $operations_event_type_code)
                                            ->where('event_classifier_code', $event_classifier_code)
                                            ->latest()
                                            ->first();
                    if (isset($est->event_time) && isset($req->event_time)) {
                        if ($est->event_time == $req->event_time) {
                            $plannedTimes = EventPlanning::where('voyage_id', $voyage->id)
                                ->where('event_type', $event_type)
                                ->where('transport_call_id', $request->transportCallID)
                                ->where('transport_event_type_code', 'PLN')
                                ->where('operations_event_type_code', $operations_event_type_code)
                                ->where('event_classifier_code', $event_classifier_code)
                                ->where('event_time', $req->event_time)
                                ->count();
                            if ($plannedTimes == 0){ 
                                $pln = new EventPlanning;
                                $pln->transport_call_id = $est->transport_call_id;
                                $pln->event_created_date_time = date('Y-m-d H:i:s');
                                $pln->event_time = $est->event_time;
                                $pln->event_type = $event_type;
                                $pln->transport_event_type_code = 'PLN';
                                $pln->operations_event_type_code = $operations_event_type_code;
                                $pln->event_classifier_code = $event_classifier_code;
                                $voyage->event_plannings()->save($pln);
                            }
                        }
                    }
                }
            }
        }

        // update status
        try {
            $transport_event_type_values = ['EST' => 1, 'REQ' => 2, 'PLN' => 3, 'ACT' => 4];
            $column_prefixes = ['berthing_status_code' => 'B', 'pilot_boarding_place_status_code' => 'P', 'start_operation_status_code' => 'S', 'completion_operation_status_code' => 'C', 'unberthing_status_code' => 'D'];

            $event_plannings = EventPlanning::where('voyage_id', $voyage->id)->orderBy('event_time', 'asc')->get();

            $event_planning_status = EventPlanningStatus::where('voyage_id', $voyage->id)
                                                        ->where('transport_call_id', $request->transportCallID)
                                                        ->first();
            foreach ($event_plannings as $event_planning) {
                if (($event_planning->event_type == 'STRT') && ($event_planning->operations_event_type_code == 'TRANSPORT') && ($event_planning->event_classifier_code == 'ARRI')) $column = 'berthing_status_code';
                if (($event_planning->event_type == 'STRT') && ($event_planning->operations_event_type_code == 'PILOTTIME') && ($event_planning->event_classifier_code == 'ARRI')) $column = 'pilot_boarding_place_status_code';
                if (($event_planning->event_type == 'STRT') && ($event_planning->operations_event_type_code == 'OPERATION') && ($event_planning->event_classifier_code == 'ARRI')) $column = 'start_operation_status_code';
                if (($event_planning->event_type == 'CMPL') && ($event_planning->operations_event_type_code == 'OPERATION') && ($event_planning->event_classifier_code == 'DEPA')) $column = 'completion_operation_status_code';
                if (($event_planning->event_type == 'CMPL') && ($event_planning->operations_event_type_code == 'TRANSPORT') && ($event_planning->event_classifier_code == 'DEPA')) $column = 'unberthing_status_code';
                $event_planning_status->{$column} = $column_prefixes[$column] . str_pad($transport_event_type_values[$event_planning->transport_event_type_code], 3, '0', STR_PAD_LEFT);
            }

            $event_planning_status->save();
        } catch (\Throwable $e) {
            Log::error([$e]);
        }
    }
}
