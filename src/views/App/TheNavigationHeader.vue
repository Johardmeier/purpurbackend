<template>
  <nav
    class="navbar has-shadow"
    role="navigation"
    aria-label="main navigation"
  >
    <div class="navbar-brand">
      <hamburger-menu />
    </div>
    <div class="navbar-menu">
      <div class="navbar-start">
        <main-menu />
      </div>

      <div class="navbar-end">
        <user-dropdown v-if="isLoggedIn" />
        <login-modal v-else />
      </div>
    </div>
  </nav>
</template>

<script lang="ts">
import { Component, Vue } from "vue-property-decorator";
import loginModal from "./loginModal.vue";
import UserDropdown from "./UserDropdown.vue";
import MainMenu from "./MainMenu.vue";
import HamburgerMenu from "./HamburgerMenu.vue";

@Component({
  components: {
    HamburgerMenu,
    MainMenu,
    loginModal,
    UserDropdown
  },
  computed: {
    isLoggedIn() {
      return this.$store.getters["authentication/isLoggedIn"];
    }
  },
  data() {
    return {};
  }
})
export default class TheNavigationHeader extends Vue {}
</script>

<!--
<a class="navbar-item is-active">Home</a>
<a class="navbar-item is-tab is-hidden-tablet">Features</a>
<a class="navbar-item is-tab is-hidden-tablet">Pricing</a>
<a class="navbar-item is-tab is-hidden-tablet">About</a>
<a class="navbar-item nav-tag">
  <span class="icon is-small"><i class="fa fa-envelope-o"></i></span>
  <span class="tag is-primary tag-notif">6</span>
</a>
-->
