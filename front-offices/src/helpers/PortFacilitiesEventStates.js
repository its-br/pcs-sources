import i18n from '@/plugins/i18n'

export const getPortFacilitiesEventStates = () => {
    return {
    card1:[
        {// 0
            event_color: "yellow",
            event_status: i18n.t('EventPlanning.PortFacility.event_status_PendingEstimatedTime'),
            event_action_text: "",
            show_action_button: false,
            dialog_type: 1,
            dialog1_title: "",
            dialog1_main_button: "",
            dialog2_title: "",
            dialog2_subtitle:""
        },
        {// 1
            event_color: "yellow",
            event_status: i18n.t('EventPlanning.PortFacility.event_status_WaitingPortAuthorityTime'),
            event_action_text: "",
            show_action_button: false,
            dialog_type: 1,
            dialog1_title: "",
            dialog1_main_button: "",
            dialog2_title: "",
            dialog2_subtitle:""
        },
        {// 2
            event_color: "red",
            event_status: i18n.t('EventPlanning.PortFacility.event_status_DifferentInformedTimes'),
            event_action_text: "",
            show_action_button: false,
            dialog_type: 2,
            dialog1_title: "",
            dialog1_main_button: "",
            dialog2_title: i18n.t('EventPlanning.PortFacility.title_PendingTime'),
            dialog2_subtitle:i18n.t('EventPlanning.PortFacility.subtitle_pending_port_authority')
        },
        {// 3
            event_color: "green",
            event_status: i18n.t('EventPlanning.PortFacility.event_status_Active'),
            event_action_text: "",
            show_action_button: false,
            dialog_type: 1,
            dialog1_title: "",
            dialog1_main_button: "",
            dialog2_title: "",
            dialog2_subtitle:""
        },
        {// 4
            event_color: "primary",
            event_status: i18n.t('EventPlanning.PortFacility.event_status_Completed'),
            event_action_text: "",
            show_action_button: false,
            dialog_type: 1,
            dialog1_title: "",
            dialog1_main_button: "",
            dialog2_title: "",
            dialog2_subtitle:""
        }
    ],
    card2:[
        {// 0
            event_color: "yellow",
            event_status: i18n.t('EventPlanning.PortFacility.event_status_WaitingMaritimeAgentTime'),
            event_action_text: "",
            show_action_button: false,
            dialog_type: 1,
            dialog1_title: "",
            dialog1_main_button: "",
            dialog2_title: "",
            dialog2_subtitle:""
        },
        {// 1
            event_color: "yellow",
            event_status: i18n.t('EventPlanning.PortFacility.event_status_PendingEstimatedTime'),
            event_action_text: i18n.t('EventPlanning.PortFacility.action_InformTime'),
            show_action_button: true,
            dialog_type: 1,
            dialog1_title: i18n.t('EventPlanning.PortFacility.title_InformTime'),
            dialog1_main_button: i18n.t('EventPlanning.PortFacility.button_Confirm'),
            dialog2_title: "",
            dialog2_subtitle:""
        },
        {// 2
            event_color: "red",
            event_status: i18n.t('EventPlanning.PortFacility.event_status_DifferentInformedTimes'),
            event_action_text: i18n.t('EventPlanning.PortFacility.action_ViewPendingTime'),
            show_action_button: true,
            dialog_type: 2,
            dialog1_title: "",
            dialog1_main_button: "",
            dialog2_title: i18n.t('EventPlanning.PortFacility.title_PendingTime'),
            dialog2_subtitle: i18n.t('EventPlanning.PortFacility.subtitle_pending_maritime_agent') 
        },
        {// 3
            event_color: "green",
            event_status: i18n.t('EventPlanning.PortFacility.event_status_Active'),
            event_action_text: "",
            show_action_button: false,
            dialog_type: 1,
            dialog1_title: "",
            dialog1_main_button: "",
            dialog2_title: "",
            dialog2_subtitle:""
        },
        {// 4
            event_color: "primary",
            event_status: i18n.t('EventPlanning.PortFacility.event_status_Completed'),
            event_action_text: "",
            show_action_button: false,
            dialog_type: 1,
            dialog1_title: "",
            dialog1_main_button: "",
            dialog2_title: "",
            dialog2_subtitle:""
        }
    ],
    card3:[
        {// 0
            event_color: "yellow",
            event_status: i18n.t('EventPlanning.PortFacility.event_status_WaitingRequestedStartCargoOperations'),
            event_action_text: i18n.t('EventPlanning.PortFacility.action_InformTime'),
            show_action_button: true,
            dialog_type: 1,
            dialog1_title: i18n.t('EventPlanning.PortFacility.title_InformTime'),
            dialog1_main_button: i18n.t('EventPlanning.PortFacility.button_Confirm'),
            dialog2_title: "",
            dialog2_subtitle:""
        },
        {// 1
            event_color: "yellow",
            event_status: i18n.t('EventPlanning.PortFacility.event_status_WaitingPortFacilityTime'),
            event_action_text: "",
            show_action_button: false,
            dialog_type: 1,
            dialog1_title: "",
            dialog1_main_button: "",
            dialog2_title: "",
            dialog2_subtitle:""
        },
        {// 2
            event_color: "yellow",
            event_status: i18n.t('EventPlanning.PortFacility.event_status_WaitingPortFacilityTime'),
            event_action_text: "",
            show_action_button: false,
            dialog_type: 1,
            dialog1_title: "",
            dialog1_main_button: "",
            dialog2_title: "",
            dialog2_subtitle:""
        },
        {// 3
            event_color: "yellow",
            event_status: i18n.t('EventPlanning.PortFacility.event_status_WaitingPortFacilityTime'),
            event_action_text: "",
            show_action_button: false,
            dialog_type: 1,
            dialog1_title: "",
            dialog1_main_button: "",
            dialog2_title: "",
            dialog2_subtitle:""
        },
        {// 4
            event_color: "primary",
            event_status: i18n.t('EventPlanning.PortFacility.event_status_Completed'),
            event_action_text: i18n.t('EventPlanning.PortFacility.action_EditTime'),
            show_action_button: true,
            dialog_type: 1,
            dialog1_title: i18n.t('EventPlanning.PortFacility.title_EditTime'),
            dialog1_main_button: i18n.t('EventPlanning.PortFacility.button_Update'),
            dialog2_title: "",
            dialog2_subtitle:""
        }
    ],
    card4:[
        {// 0
            event_color: "yellow",
            event_status: i18n.t('EventPlanning.PortFacility.event_status_InformEstimatedCargoCompletionTime'),
            event_action_text: i18n.t('EventPlanning.PortFacility.action_InformTime'),
            show_action_button: true,
            dialog_type: 1,
            dialog1_title: i18n.t('EventPlanning.PortFacility.title_InformTime'),
            dialog1_main_button: i18n.t('EventPlanning.PortFacility.button_Confirm'),
            dialog2_title: "",
            dialog2_subtitle:""
        },
        {// 1
            event_color: "yellow",
            event_status: i18n.t('EventPlanning.PortFacility.event_status_WaitingMaritimeAgentTime'),
            event_action_text: i18n.t('EventPlanning.PortFacility.action_EditTime'),
            show_action_button: true,
            dialog_type: 1,
            dialog1_title: i18n.t('EventPlanning.PortFacility.title_EditTime'),
            dialog1_main_button: i18n.t('EventPlanning.PortFacility.button_Update'),
            dialog2_title: "",
            dialog2_subtitle:""
        },
        {// 2
            event_color: "red",
            event_status: i18n.t('EventPlanning.PortFacility.event_status_DifferentInformedTimes'),
            event_action_text: i18n.t('EventPlanning.PortFacility.action_ViewPendingTime'),
            show_action_button: true,
            dialog_type: 2,
            dialog1_title: i18n.t('EventPlanning.PortFacility.title_EditTime'),
            dialog1_main_button: i18n.t('EventPlanning.PortFacility.button_Update'),
            dialog2_title: i18n.t('EventPlanning.PortFacility.title_PendingTime'),
            dialog2_subtitle: i18n.t('EventPlanning.PortFacility.subtitle_pending_maritime_agentCargoCompletion')
        },
        {// 3
            event_color: "green",
            event_status: i18n.t('EventPlanning.PortFacility.event_status_Active'),
            event_action_text: i18n.t('EventPlanning.PortFacility.action_Complete'),
            show_action_button: true,
            dialog_type: 1,
            dialog1_title: i18n.t('EventPlanning.PortFacility.title_InformActualTime'),
            dialog1_main_button: i18n.t('EventPlanning.PortFacility.button_Confirm'),
            dialog2_title: "",
            dialog2_subtitle:""
        },
        {// 4
            event_color: "primary",
            event_status: i18n.t('EventPlanning.PortFacility.event_status_Completed'),
            event_action_text: i18n.t('EventPlanning.PortFacility.action_EditTime'),
            show_action_button: true,
            dialog_type: 1,
            dialog1_title: i18n.t('EventPlanning.PortFacility.title_EditTime'),
            dialog1_main_button: i18n.t('EventPlanning.PortFacility.button_Update'),
            dialog2_title: "",
            dialog2_subtitle:""
        }
    ],
    card5:[
        {// 0
            event_color: "yellow",
            event_status: i18n.t('EventPlanning.PortFacility.event_status_InformEstimatedBerthDeparture'),
            event_action_text: i18n.t('EventPlanning.PortFacility.action_InformTime'),
            show_action_button: true,
            dialog_type: 1,
            dialog1_title: i18n.t('EventPlanning.PortFacility.action_InformTime'),
            dialog1_main_button: i18n.t('EventPlanning.PortFacility.button_Confirm'),
            dialog2_title: "",
            dialog2_subtitle:""
        },
        {// 1
            event_color: "yellow",
            event_status: i18n.t('EventPlanning.PortFacility.event_status_WaitingMaritimeAgentTime'),
            event_action_text: i18n.t('EventPlanning.PortFacility.action_EditTime'),
            show_action_button: true,
            dialog_type: 1,
            dialog1_title: i18n.t('EventPlanning.PortFacility.title_EditTime'),
            dialog1_main_button: i18n.t('EventPlanning.PortFacility.button_Update'),
            dialog2_title: "",
            dialog2_subtitle:""
        },
        {// 2
            event_color: "red",
            event_status: i18n.t('EventPlanning.PortFacility.event_status_DifferentInformedTimes'),
            event_action_text: i18n.t('EventPlanning.PortFacility.action_ViewPendingTime'),
            show_action_button: true,
            dialog_type: 2,
            dialog1_title: i18n.t('EventPlanning.PortFacility.title_EditTime'),
            dialog1_main_button: i18n.t('EventPlanning.PortFacility.button_Update'),
            dialog2_title: i18n.t('EventPlanning.PortFacility.title_PendingTime'),
            dialog2_subtitle: i18n.t('EventPlanning.PortFacility.subtitle_pending_maritime_agentBerthDeparture') 
        },
        {// 3
            event_color: "green",
            event_status: i18n.t('EventPlanning.PortFacility.event_status_Active'),
            event_action_text: i18n.t('EventPlanning.PortFacility.action_Complete'),
            show_action_button: true,
            dialog_type: 1,
            dialog1_title: i18n.t('EventPlanning.PortFacility.title_InformActualTime'),
            dialog1_main_button: i18n.t('EventPlanning.PortFacility.button_Confirm'),
            dialog2_title: "",
            dialog2_subtitle:""
        },
        {// 4
            event_color: "primary",
            event_status: i18n.t('EventPlanning.PortFacility.event_status_Completed'),
            event_action_text: i18n.t('EventPlanning.PortFacility.action_EditTime'),
            show_action_button: true,
            dialog_type: 1,
            dialog1_title: i18n.t('EventPlanning.PortFacility.title_EditTime'),
            dialog1_main_button: i18n.t('EventPlanning.PortFacility.button_Update'),
            dialog2_title: "",
            dialog2_subtitle:""
        }
    ]}
}