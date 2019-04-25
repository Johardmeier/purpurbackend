<template>
  <section>
    <div class="navbar-item">
      <a class="button is-primary" @click="isComponentModalActive = true">
        <b-icon pack="fas" icon="sign-in-alt" />
        <span>Login</span>
      </a>
    </div>

    <b-modal :active.sync="isComponentModalActive" has-modal-card>
      <form>
        <div class="modal-card" style="width: auto">
          <header class="modal-card-head">
            <p class="modal-card-title">Login</p>
          </header>
          <section class="modal-card-body">
            <b-field label="Email">
              <b-input
                type="email"
                :value="email"
                placeholder="Your email"
                required
              >
              </b-input>
            </b-field>

            <b-field label="Password">
              <b-input
                type="password"
                :value="password"
                password-reveal
                placeholder="Your password"
                required
              >
              </b-input>
            </b-field>

            <b-checkbox>Remember me</b-checkbox>
          </section>
          <footer class="modal-card-foot">
            <button
              class="button"
              type="button"
              @click="isComponentModalActive = true"
            >
              Close
            </button>
            <button class="button is-primary" type="button" @click="oldLogin()">
              Login
            </button>
          </footer>
        </div>
      </form>
    </b-modal>
  </section>
</template>

<script lang="ts">
import Vue, { Component } from "vue";

export default Vue.extend({
  data() {
    return {
      isComponentModalActive: false,
      email: "admin@theater-purpur.ch",
      password: "abc"
    };
  },
  methods: {
    oldLogin() {
      this.$store
        .dispatch("authentication/logIn", {
          username: "admin@theater-purpur.ch",
          password: "abc"
        })
        .then(() => {
          this.isComponentModalActive = false;
        });
    },
    doLogin() {
      this.$store.dispatch("authentication/logIn", {
        username: this.email,
        password: this.password
      });
    }
  }
});
</script>

<!--
<script lang="ts">
  import { Component, Vue } from "vue-property-decorator";

  @Component
  export default class loginModal extends Vue {
    isComponentModalActive = false;
    email = "admin@theater-purpur.ch";
    password = "abc";
    oldLogin() {
      this.$store.dispatch("authentication/logIn", {
        username: "admin@theater-purpur.ch",
        password: "abc"
      });
    }
    doLogin() {
      this.$store.dispatch("authentication/logIn", {
        username: this.email,
        password: this.password
      });
    }
  }
</script>
-->

<style scoped></style>
