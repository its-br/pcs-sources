import {profile, profiles} from '../helpers/profiles'
export const portAuthorityRoutes = [
  {
    path: '/PortAuthority',
    component: () => import('../views/AdminIndex.vue'),
    children:[
      {
        path: 'Info',
        meta: { authorize: [profile.PortAuthority] },
        component: () => import('../components/PortAuthority/PortAuthorityInfo.vue')
      },
      {
        path: '',
        meta: { authorize: [profile.PortAuthority] },
        component: () => import('../components/PortAuthority/Kanban.vue')
      }
    ]
  }
]
