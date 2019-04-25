<template>
  <div class="navbar-item">
    <a
      class="navbar-item button is-success is-outlined"
      @click="toggleSidemenu()"
    >
      <b-icon icon="bars" pack="fas" v-if="hideSidemenu" />
      <b-icon icon="angle-left" pack="fas" v-else />
    </a>
  </div>
</template>

<script lang="ts">
import { Component, Vue } from "vue-property-decorator";
@Component({
  methods: {
    toggleSidemenu() {
      this.$store.commit("application/toggleSidemenu");
    }
  },
  computed: {
    hideSidemenu() {
      return this.$store.state.application.hideSidemenu;
    }
  }
})
export default class HamburgerMenu extends Vue {}
</script>
