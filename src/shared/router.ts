import Vue from "vue";
import Router, { RouteConfig } from "vue-router";
import Store from "./store";

import Login from "@/views/Auth/Login.vue";
import ResetPass from "@/views/Auth/ResetPass.vue";

import Home from "../views/Home.vue";
import Placeholder from "../views/Placeholder.vue";
import route404 from "../views/route404.vue";
import NestedRoute from "../views/App/NestedRoute.vue";

Vue.use(Router);

export interface routeMeta {
  title: string;
  authLevel: string[];
  defaultPath?: string;
  icon: string;
  group?: {name: string, title:string, icon:string};
}

export interface authRouteConfig extends RouteConfig {
  name: string;
  children?: authRouteConfig[];
  meta: routeMeta;
}

/* eslint-disable */
export const authRoutes:authRouteConfig[]=[
  { path: "/config", name: "config",
    meta:{ title: "Administration", authLevel: ["admin"], icon: "cog"},
    component: NestedRoute,
    children: [
      { path: "/config/users",name: "users",
        meta:{title: "Benutzer", authLevel: ["admin"], icon: "users"},
        component: () => import("../views/User/Cards.vue")
      },
      { path: "/config/languages",name: "languages_old",
        meta:{title: "Sprachen", authLevel: ["general","public", "admin"],icon: "globe"},
        component: () => import("../views/Models/Languages.vue")
      },
      { path: "/config/three",name: "three1",
        meta:{title: "Drei", authLevel: ["general","admin"], icon: "spider"},
        component: () => import("../views/About.vue")
      },
    ]
  },
  { path: "/plays", name: "header_plays",
    meta:{ title: "Theater", authLevel: ["public","admin"], icon: "theater-masks"},
    component: NestedRoute,
    children: [
      { path: "/plays/tests",name: "tests",
        meta:{title:"Tests", authLevel: ["public","admin"], icon: "stethoscope"},
        component: () => import("../views/common/testInput.vue")
      },
      { path: "/plays/plays",name: "plays",
        meta:{title:"Stücke", authLevel: ["public","admin"], icon: "book-open"},
        component: () => import("../views/Models/Plays.vue")
      },
      { path: "/plays/performances",name: "performances",
        meta:{title:"Aufführungen", authLevel: ["public","admin"], icon: "calendar-alt"},
        component: () => import("../views/Models/Performances.vue")
      },
      { path: "/plays/artists",name: "artists",
        meta:{title:"Künstler", authLevel: ["public","admin"], icon: "crown"},
        component: () => import("../views/Models/Artists.vue")
      },
      { path: "/plays/performancetypes",name: "performancetypes",
        meta:{title:"Vorstellungstyp", authLevel: ["public","admin"], icon: "tags", group: {name:"config", title:"Einstellungen", icon:"cog"}},
        component: () => import("../views/Models/PerformanceTypes.vue")
      },
      { path: "/plays/languages",name: "languages",
        meta:{title: "Sprachen", authLevel: ["public", "admin"], icon: "globe", group: {name:"config", title:"Einstellungen", icon:"cog"}},
        component: () => import("../views/Models/Languages.vue")
      },
      { path: "/plays/capacities",name: "capacities",
        meta:{title: "Sitzplätze", authLevel: ["public", "admin"], icon: "users", group: {name:"config", title:"Einstellungen", icon:"cog"}},
        component: () => import("../views/Models/PlayCapacities.vue")
      },
      { path: "/plays/pricestructures",name: "pricestructures",
        meta:{title: "Preismodelle", authLevel: ["public", "admin"], icon: "money-bill-alt", group: {name:"config", title:"Einstellungen", icon:"cog"}},
        component: () => import("../views/Models/PriceStructures.vue")
      },
    ]
  },
  { path: "/tickets", name: "tickets",
    meta:{ title: "Tickets", authLevel: ["public","admin"], icon: "ticket-alt"},
    component: NestedRoute,
    children: [
      { path: "/tickets/one",name: "one3",
        meta:{title:"Eins", authLevel: ["public"], icon: "home"},
        component: () => import("../views/App/sortabletest.vue"),
      },
      { path: "/tickets/two",name: "two3",
        meta:{title:"Zwei", authLevel: ["admin"], icon: "home"},
        component: () => import("../views/About.vue")
      },
      { path: "/tickets/three",name: "three3",
        meta:{title:"Drei", authLevel: ["public"], icon: "home"},
        component: () => import("../views/Third.vue")
      },
    ]
  },
  //catch all
  {path: "/404", name: "404", meta:{title:"Not Found", authLevel: ["internal"], icon: "home"}, component: route404},
  {path: "*", name: "catchAll", meta:{title:"Not Found", authLevel: ["internal"], icon: "home"}, component: route404},
];

/* eslint-enable */

export const router = new Router({
  mode: "history",
  base: process.env.BASE_URL,
  routes: authRoutes
});

export function authorizedRoutes(): authRouteConfig[] {
  let authArray = Store.getters["authentication/getRoles"];

  function authDenied(el: any): boolean {
    return (
      el.meta &&
      el.meta.authLevel &&
      !el.meta.authLevel.some((x: string) => authArray.includes(x))
    );
  }

  function copy(o: any): any {
    return Array.isArray(o)
      ? copyArray(o)
      : typeof o === "object" && o !== null
      ? copyObject(o)
      : o;
  }

  function copyArray(o: Array<Object>): Array<Object> {
    let out = [];
    for (let el of o) if (!authDenied(el)) out.push(copy(el));
    return out;
  }

  function copyObject(o: any): Object {
    let out: any = {};
    for (let key in o) {
      // noinspection JSUnfilteredForInLoop
      out[key] = copy(o[key]);
    }
    return out;
  }
  return <authRouteConfig[]>copyArray(authRoutes);
}

router.beforeEach((to, from, next) => {
  let authArray = Store.getters["authentication/getRoles"];

  if (
    to.meta &&
    to.meta.authLevel &&
    !to.meta.authLevel.some((x: string) => authArray.includes(x))
  ) {
    let aR=authorizedRoutes();
    let nR = aR[0].children ? aR[0].children[0].path : aR[0].path;
    next(nR);
  }
  next();
});
