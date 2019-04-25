<template>
  <div class="navbar-item has-dropdown is-hoverable">
    <a class="navbar-link">
      <figure class="image is-32x32" style="margin-right:.5em;">
        <img
          v-bind:src="userPicture"
          alt="user picture"
        />
      </figure>
    </a>
    <div class="navbar-dropdown is-right">
      <a class="navbar-item">
        <span class="icon is-small"><i class="fa fa-user"></i></span>Profile
      </a>
      <hr class="navbar-divider" />
      <a class="navbar-item" @click="logOut()">
        <span class="icon is-small"><i class="fa fa-power-off"></i>Logout</span>
      </a>
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Vue } from "vue-property-decorator";

@Component({
  methods: {
    logOut() {
      this.$store.dispatch("authentication/logOut");
    }
  },
  computed: {
    userPicture() {
      let st = this.$store;
      let im = st.getters["authentication/userImage"];
      return "data:image/jpeg;base64," + im;
    }
  },
  data() {
    return {};
  }
})
export default class UserDropdown extends Vue {}
</script>

<style scoped></style>
