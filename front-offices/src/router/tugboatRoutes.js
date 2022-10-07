import {profile, profiles} from '../helpers/profiles'
export const tugboatRoutes = [
  {
    path: '/Tugboat',
    redirect: '/Tugboat/info',
    component: () => import('../views/AdminIndex.vue'),
    children:[
      {
        path: 'Info',
        meta: { authorize: [profile.Tugboat] },
        component: () => import('../components/Tugboat/TugboatInfo.vue')
      }
    ]
  },
  {
    path: '/Tugboat',
    component: () => import('../views/Tugboat.vue'),
    children:[
      {
        path: 'Create',
        meta: { authorize: [profile.Tugboat] },
        component: () => import('../components/Tugboat/TugboatForm.vue'),
      }
    ]
  },
]
