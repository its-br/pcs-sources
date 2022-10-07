import {maritimeAgentRoutes} from './maritimeAgentRoutes'
import {maritimeAgentSecondaryRoutes} from './maritimeAgentSecondaryRoutes'
import {mooringOperatorsRoutes} from './mooringOperatorsRoutes'
import {portFacilitiesRoutes} from './portFacilitiesRoutes'
import {portAuthorityRoutes} from './portAuthorityRoutes'
import {tugboatRoutes} from './tugboatRoutes'
import {userAgentRoutes} from './userAgentRoutes'
import {shipSupplierRoutes} from './shipSupplierRoutes'
import {profile, profiles} from '../helpers/profiles'


const defaultRoutes = [
  {
    path: '*',
    name: "404",
    component: () => import('../views/errors/404.vue')
  },
  {
    path: '/',
    name: "Home",
  },
  {
    path: '/locale',
    name: "ChangeLocale",
    component: () => import('../views/ChangeLocale.vue'),
  },
  {
    path: '/login',
    name: "Login",
    component: () => import('../views/LoginOAuth.vue')
  },
  {
    path: '/logout',
    component: () => import('../views/AdminIndex.vue'),
    children:[
      {
        path: 'success',
        component: () => import('../views/Logout.vue')
      },
      {
        path: '',
        component: () => import('../views/Logout.vue')
      }
    ]
  },
  {
    path: '/callback',
    name: "Callback",
    component: () => import('../views/LoginOAuth.vue')
  },
  {
    path: '/AddUserAgent',
    component: () => import('../views/AdminIndex.vue'),
    children:[
      {
        path: '/',
        component: () => import('../views/AddUserAgent.vue')
      }
    ]
  },
  {
    path: '/UserInfo',
    name: '/UserInfo',
    component: () => import('../views/AdminIndex.vue'),
    children:[
      {
        path: '',
        component: () => import('../components/UserInfo.vue')
      }
    ]
  },
  {
    path: '/Voyage',
    component: () => import('../views/AdminIndex.vue'),
    children:[
      {
        path: 'Creation',
        meta: { authorize: [profile.MaritimeAgent] },
        component: () => import('../components/Voyage/Creation/VoyageCreation.vue')
      }
    ]
  },
  {
    /**
     * Teoricamente seria necessario informar somente o PCSVoyageID, pois uma Viagem poderia ter mais de uma parada,
     * Por hora será considerado que cada viagem possui apenas 1 parada e será informado o transportCallID
     */
    path: '/EventPlanning/:PCSVoyageID/:TransportCallID',
    component: () => import('../views/AdminIndex.vue'),
    children:[
      {
        path: '',
        meta: { authorize: [profile.MaritimeAgent, profile.PortFacilities, profile.PortAuthority, profile.HarborPilot] },
        component: () => import('../components/EventPlanning/TimelineEvents.vue')
      }
    ]
  },
  {
    path: '/HarborPilot',
    component: () => import('../views/AdminIndex.vue'),
    children:[
      {
        path: '',
        meta: { authorize: [profile.HarborPilot] },
        component: () => import('../components/HarborPilot/PilotDashboard.vue')
      }
    ]
  }
]
export const routes = defaultRoutes
  .concat(maritimeAgentRoutes)
  .concat(maritimeAgentSecondaryRoutes)
  .concat(mooringOperatorsRoutes)
  .concat(portFacilitiesRoutes)
  .concat(portAuthorityRoutes)
  .concat(tugboatRoutes)
  .concat(shipSupplierRoutes)
  .concat(userAgentRoutes)