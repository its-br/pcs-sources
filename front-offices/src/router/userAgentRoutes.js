import {profile, profiles} from '../helpers/profiles'
export const userAgentRoutes = [
  {
    path: '/UserAgent',
    redirect: '/UserAgent/info',
    component: () => import('../views/AdminIndex.vue'),
    children:[
      {
        path: 'Info',
        meta: { authorize: [profile.UserAgent] },
        component: () => import('../components/UserAgent/UserAgentInfo.vue')
      }
    ]
  },
  {
    path: '/UserAgent',
    component: () => import('../views/UserAgent.vue'),
    children:[
      {
        path: 'Create',
        meta: { authorize: [profile.UserAgent] },
        component: () => import('../components/UserAgent/UserAgentForm.vue')
      }
    ]
  }
]
