<template>
  <div class="navbar-item buttons has-addons">
    <router-link
      class="button is-success is-rounded"
      v-for="ro in cRoutes"
      :key="ro.index"
      :class="{ 'is-outlined': !routeMatches(ro.name) }"
      :to="ro.children ? ro.children[0].path : ro.path"
    >
      <!--:to="ro.children[0].path"-->
      <b-tooltip :label="ro.meta.title" position="is-bottom">
        <span class="icon">
          <b-icon pack="fas" v-bind:icon="ro.meta.icon" />
        </span>
        <span>{{ ro.meta.title }}</span>
      </b-tooltip>
    </router-link>
  </div>
</template>

<script lang="ts">
import Vue, { Component } from "vue";
import { authorizedRoutes, authRouteConfig } from "@/shared/router";

export default Vue.extend({
  data() {
    return {
      //activeNav: ""
    };
  },
  computed: {
    cRoutes(): authRouteConfig[] {
      return authorizedRoutes();

      /*
      return authorizedRoutes().filter(
        ({ meta }) => meta.navGroup.includes("toplevel")
      );
*/
    },
    activeNav(): string {
      return this["$store"].getters["application/navGroup"];
    }
  },
  methods: {
    routeIt(){
      this.$router.push("404");
    },
    routeTo(element: authRouteConfig) {
      let newRoute='404';
      if (element.component)
        newRoute = element.name ? element.name : element.path
      else if (
        element.children &&
        element.children[0] &&
        element.children[0].component
      )
        newRoute = element.children[0].path;
      this.$router.push(newRoute);
    },
    routeMatches(routeName: string): boolean {
      return this.$route.matched.some(item => item.name === routeName);
    }
  }
});
</script>

<style scoped lang="scss"></style>