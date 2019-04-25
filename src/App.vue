<template>
  <div id="app" class="columns is-gapless" style="">
    <aside class="column is-narrow has-shadow" style="">
      <TheLeftNavigation />
    </aside>
    <div class="column is-gapless">
      <the-navigation-header />
      <main id="main-content" class="main">
        <transition><router-view /></transition>
      </main>
      <the-page-footer />
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Vue } from "vue-property-decorator";
import TheLeftNavigation from "@/views/App/TheLeftNavigation.vue";
import TheNavigationHeader from "@/views/App/TheNavigationHeader.vue";
//import Breadcrumbs from "@/views/App/Breadcrumbs.vue";
import ThePageFooter from "@/views/App/ThePageFooter.vue";

@Component({
  components: {
    ThePageFooter,
    TheLeftNavigation,
    TheNavigationHeader,
    //    Breadcrumbs
  }
})
export default class App extends Vue {}
</script>

<style lang="scss"></style>
