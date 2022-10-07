import {profile, profiles} from '../helpers/profiles'
export const maritimeAgentRoutes = [
  {
    path: '/MaritimeAgent',
    component: () => import('../views/AdminIndex.vue'),
    children:[
      {
        path: 'Info',
        meta: { authorize: [profile.MaritimeAgent] },
        component: () => import('../components/MaritimeAgent/MaritimeAgentInfo.vue')
      },
      {
        path: 'Update',
        meta: { authorize: [profile.MaritimeAgent] },
        component: () => import('../components/MaritimeAgent/MaritimeAgentForm.vue')
      },
      {
        path: 'Create',
        meta: { authorize: [profile.MaritimeAgent] },
        component: () => import('../components/MaritimeAgent/MaritimeAgentForm.vue')
      },
      {
        path: '',
        meta: { authorize: [profile.MaritimeAgent] },
        component: () => import('../components/MaritimeAgent/Kanban.vue')
      }
    ]
  }
]
