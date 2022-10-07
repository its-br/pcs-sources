import {profile, profiles} from '../helpers/profiles'
export const maritimeAgentSecondaryRoutes = [
  {
    path: '/MaritimeAgentSecondary',
    component: () => import('../views/AdminIndex.vue'),
    children:[
      {
        path: '',
        meta: { authorize: [profile.MaritimeAgentSecondary] },
        component: () => import('../components/MaritimeAgentSecondary/Responsability.vue')
      }
    ]
  }
]
