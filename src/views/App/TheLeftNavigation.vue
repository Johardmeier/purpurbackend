<template>
  <nav class="menu">
    <div class="title-panel has-text-success">
      <img
        class="purpur-logo"
        src="@/assets/PurPurLogo.png"
        alt="Theater PurPur Admin"
      />
      <!--<p>Admin Panel</p>-->
    </div>
    <!--<div class="box">OK</div>-->
    <!--<p class="menu-label">Administration</p>-->
    <div class="menu-list" style="margin: 12px;">
      <!--<p class="has-text-success" style="margin: 6px; padding: 6px;">-->
      <!--Menu-->
      <!--</p>-->
      <div
        v-for="(routeGroup, routeGroupName) in cRoutes"
        :key="routeGroupName"
      >

        <div v-if="routeGroupName==='default'">
          <router-link

            v-for="ro in routeGroup"
            :key="ro.index"
            :to="ro.path"
            class="has-text-success"
          >
            <span class="icon has-text-success">
              <b-icon pack="fas" v-bind:icon="ro.meta.icon" />
            </span>
            <span style="padding-left: 6px;">{{ ro.meta.title }}</span>
          </router-link>
        </div>
        <b-collapse v-else :open="false">
          <a slot="trigger" slot-scope="prop" class="has-text-success">
            <span class="icon has-text-success">
              <b-icon v-if="prop.open" pack="fas" icon="chevron-down" />
              <b-icon v-else pack="fas" icon="chevron-right" />
            </span>
<!--
            <span class="icon has-text-success">
              <b-icon pack="fas" :icon="routeGroup[0].meta.group.icon" />
            </span>
-->
            <span style="padding-left: 6px;">{{ routeGroup[0].meta.group.title }}</span>
          </a>
          <div style="margin-left: 0.75em;">
            <router-link
              v-for="ro in routeGroup"
              :key="ro.index"
              :to="ro.path"
              class="has-text-success"
            >
              <span class="icon has-text-success">
                <b-icon pack="fas" v-bind:icon="ro.meta.icon" />
              </span>
              <span style="padding-left: 6px;">{{ ro.meta.title }}</span>
            </router-link>
          </div>
        </b-collapse>
      </div>
    </div>
  </nav>
</template>

<script lang="ts">
import Vue, { Component } from "vue";
import { authRouteConfig } from "@/shared/router";
import { authorizedRoutes } from "@/shared/router";

interface groupedRoute {
  [key: string]: authRouteConfig[];
}

export default Vue.extend({
  data() {
    return {};
  },
  computed: {
    cRoutes(): groupedRoute | null {
      let mainRouteName =
        this.$route.matched &&
        this.$route.matched[0] &&
        this.$route.matched[0].name
          ? this.$route.matched[0].name
          : "";
      let aR = authorizedRoutes().filter(({ name }) => mainRouteName === name);
      let childRoutes = aR && aR[0] && aR[0].children ? aR[0].children : null;
      return childRoutes
        ? childRoutes.reduce((acc: groupedRoute, p: authRouteConfig) => {
            let grp = p.meta.group ? p.meta.group.name : "default";
            acc[grp] ? acc[grp].push(p) : (acc[grp] = [p]);
            return acc;
          }, {})
        : null;

      //TODO Make sure MR[0] is always the main chosen
      //     and aR has exactly one, with children
      // vielleicht sogar: open wenn aktuelle Route in der Gruppe ist...
    }
  }
});
</script>

<style scoped></style>
