import i18n from '@/plugins/i18n'

export const getMaritimeAgentEventStates = () => {
 return {card1:[
    {// 0
        event_color: "yellow",
        event_status: i18n.t('EventPlanning.MartimeAgent.event_status_PendingEstimatedTime'),
        event_action_text: i18n.t('EventPlanning.MartimeAgent.action_InformTime'),
        show_action_button: true,
        dialog_type: 1,
        dialog1_title: i18n.t('EventPlanning.MartimeAgent.title_InformTime'),
        dialog1_main_button: i18n.t('EventPlanning.MartimeAgent.button_Confirm'),
        dialog2_title: "",
        dialog2_subtitle:""
    },
    {// 1
        event_color: "yellow",
        event_status: i18n.t('EventPlanning.MartimeAgent.event_status_WaitingPortAuthorityTime'),
        event_action_text: i18n.t('EventPlanning.MartimeAgent.action_EditTime'),
        show_action_button: true,
        dialog_type: 1,
        dialog1_title: i18n.t('EventPlanning.MartimeAgent.title_EditTime'),
        dialog1_main_button: i18n.t('EventPlanning.MartimeAgent.button_Update'),
        dialog2_title: "",
        dialog2_subtitle:""
    },
    {// 2
        event_color: "red",
        event_status: i18n.t('EventPlanning.MartimeAgent.event_status_DifferentInformedTimes'),
        event_action_text: i18n.t('EventPlanning.MartimeAgent.action_ViewPendingTime'),
        show_action_button: true,
        dialog_type: 2,
        dialog1_title: "",
        dialog1_main_button: "",
        dialog2_title: i18n.t('EventPlanning.MartimeAgent.title_PendingTime'),
        dialog2_subtitle: i18n.t('EventPlanning.MartimeAgent.subtitle_pending_port_authority')
    },
    {// 3
        event_color: "green",
        event_status: i18n.t('EventPlanning.MartimeAgent.event_status_Active'),
        event_action_text: i18n.t('EventPlanning.MartimeAgent.action_Complete'),
        show_action_button: true,
        dialog_type: 1,
        dialog1_title: i18n.t('EventPlanning.MartimeAgent.title_InformActualTime'),
        dialog1_main_button: i18n.t('EventPlanning.MartimeAgent.button_Confirm'),
        dialog2_title: "",
        dialog2_subtitle:""
    },
    {// 4
        event_color: "primary",
        event_status: i18n.t('EventPlanning.MartimeAgent.event_status_Completed'),
        event_action_text: i18n.t('EventPlanning.MartimeAgent.action_Edit'),
        show_action_button: true,
        dialog_type: 1,
        dialog1_title: i18n.t('EventPlanning.MartimeAgent.title_Edit'),
        dialog1_main_button: i18n.t('EventPlanning.MartimeAgent.button_Update'),
        dialog2_title: "",
        dialog2_subtitle:""
    }
],
card2:[
    {// 0
        event_color: "yellow",
        event_status: i18n.t('EventPlanning.MartimeAgent.event_status_PendingEstimatedTime'),
        event_action_text: i18n.t('EventPlanning.MartimeAgent.action_InformTime'),
        show_action_button: true,
        dialog_type: 1,
        dialog1_title: i18n.t('EventPlanning.MartimeAgent.title_InformTime'),
        dialog1_main_button: i18n.t('EventPlanning.MartimeAgent.button_Confirm'),
        dialog2_title: "",
        dialog2_subtitle:""
    },
    {// 1
        event_color: "yellow",
        event_status: i18n.t('EventPlanning.MartimeAgent.event_status_WaitingPortFacilityTime'),
        event_action_text: i18n.t('EventPlanning.MartimeAgent.action_EditTime'),
        show_action_button: true,
        dialog_type: 1,
        dialog1_title: i18n.t('EventPlanning.MartimeAgent.title_EditTime'),
        dialog1_main_button: i18n.t('EventPlanning.MartimeAgent.button_Update'),
        dialog2_title: "",
        dialog2_subtitle:""
    },
    {// 2
        event_color: "red",
        event_status: i18n.t('EventPlanning.MartimeAgent.event_status_DifferentInformedTimes'),
        event_action_text: i18n.t('EventPlanning.MartimeAgent.action_ViewPendingTime'),
        show_action_button: true,
        dialog_type: 2,
        dialog1_title: "",
        dialog1_main_button: "",
        dialog2_title: i18n.t('EventPlanning.MartimeAgent.title_PendingTime'),
        dialog2_subtitle: i18n.t('EventPlanning.MartimeAgent.subtitle_pending_port_facility')
    },
    {// 3
        event_color: "green",
        event_status: i18n.t('EventPlanning.MartimeAgent.event_status_Active'),
        event_action_text: i18n.t('EventPlanning.MartimeAgent.action_Complete'),
        show_action_button: true,
        dialog_type: 1,
        dialog1_title: i18n.t('EventPlanning.MartimeAgent.title_InformActualTime'),
        dialog1_main_button: i18n.t('EventPlanning.MartimeAgent.button_Confirm'),
        dialog2_title: "",
        dialog2_subtitle:""
    },
    {// 4
        event_color: "primary",
        event_status: i18n.t('EventPlanning.MartimeAgent.event_status_Completed'),
        event_action_text: i18n.t('EventPlanning.MartimeAgent.action_Edit'),
        show_action_button: true,
        dialog_type: 1,
        dialog1_title: i18n.t('EventPlanning.MartimeAgent.title_EditTime'),
        dialog1_main_button: i18n.t('EventPlanning.MartimeAgent.button_Update'),
        dialog2_title: "",
        dialog2_subtitle:""
    }
],
card3:[
    {// 0
        event_color: "yellow",
        event_status: i18n.t('EventPlanning.MartimeAgent.event_status_WaitingPortFacilityTime'),
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
        event_status: i18n.t('EventPlanning.MartimeAgent.event_status_WaitingPortFacilityTime'),
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
        event_status: i18n.t('EventPlanning.MartimeAgent.event_status_WaitingPortFacilityTime'),
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
        event_status: i18n.t('EventPlanning.MartimeAgent.event_status_WaitingPortFacilityTime'),
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
        event_status: i18n.t('EventPlanning.MartimeAgent.event_status_Completed'),
        event_action_text: "",
        show_action_button: false,
        dialog_type: 1,
        dialog1_title: "",
        dialog1_main_button: "",
        dialog2_title: "",
        dialog2_subtitle:""
    }
],
card4:[
    {// 0
        event_color: "yellow",
        event_status: i18n.t('EventPlanning.MartimeAgent.event_status_WaitingPortFacilityTime'),
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
        event_status: i18n.t('EventPlanning.MartimeAgent.event_status_InformRequestedCargoCompletionTime'),
        event_action_text: i18n.t('EventPlanning.MartimeAgent.action_InformTime'),
        show_action_button: true,
        dialog_type: 1,
        dialog1_title: i18n.t('EventPlanning.MartimeAgent.title_InformRequestedTime'),
        dialog1_main_button: i18n.t('EventPlanning.MartimeAgent.button_Confirm'),
        dialog2_title: "",
        dialog2_subtitle:""
    },
    {// 2
        event_color: "red",
        event_status: i18n.t('EventPlanning.MartimeAgent.event_status_WaitingForResolution'),
        event_action_text: i18n.t('EventPlanning.MartimeAgent.action_EditTime'),
        show_action_button: true,
        dialog_type: 1,
        dialog1_title: i18n.t('EventPlanning.MartimeAgent.title_EditRequestedTime'),
        dialog1_main_button: i18n.t('EventPlanning.MartimeAgent.button_Update'),
        dialog2_title: "",
        dialog2_subtitle:""
    },
    {// 3
        event_color: "green",
        event_status: i18n.t('EventPlanning.MartimeAgent.event_status_Active'),
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
        event_status: i18n.t('EventPlanning.MartimeAgent.event_status_Completed'),
        event_action_text: "",
        show_action_button: false,
        dialog_type: 1,
        dialog1_title: "",
        dialog1_main_button: "",
        dialog2_title: "",
        dialog2_subtitle:""
    }
],
card5:[
    {// 0
        event_color: "yellow",
        event_status: i18n.t('EventPlanning.MartimeAgent.event_status_WaitingPortFacilityTime'),
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
        event_status: i18n.t('EventPlanning.MartimeAgent.event_status_InformRequestedCargoCompletionTime'),
        event_action_text: i18n.t('EventPlanning.MartimeAgent.action_InformTime'),
        show_action_button: true,
        dialog_type: 1,
        dialog1_title: i18n.t('EventPlanning.MartimeAgent.title_InformRequestedTime'),
        dialog1_main_button: i18n.t('EventPlanning.MartimeAgent.button_Confirm'),
        dialog2_title: "",
        dialog2_subtitle:""
    },
    {// 2
        event_color: "red",
        event_status: i18n.t('EventPlanning.MartimeAgent.event_status_WaitingForResolution'),
        event_action_text: i18n.t('EventPlanning.MartimeAgent.action_EditTime'),
        show_action_button: true,
        dialog_type: 1,
        dialog1_title: i18n.t('EventPlanning.MartimeAgent.title_EditRequestedTime'),
        dialog1_main_button: i18n.t('EventPlanning.MartimeAgent.button_Update'),
        dialog2_title: "",
        dialog2_subtitle:""
    },
    {// 3
        event_color: "green",
        event_status: i18n.t('EventPlanning.MartimeAgent.event_status_Active'),
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
        event_status: i18n.t('EventPlanning.MartimeAgent.event_status_Completed'),
        event_action_text: "",
        show_action_button: false,
        dialog_type: 1,
        dialog1_title: "",
        dialog1_main_button: "",
        dialog2_title: "",
        dialog2_subtitle:""
    }
] }
}