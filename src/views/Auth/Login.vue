<template>
  <div>
    <h4>This is the LOGIN Route</h4>
    <h3>LOGIN FIRST</h3>
    <button v-on:click="testApi()">Lgoin ></button>
    <button v-on:click="testApiWrong()">Wrong login ></button>
    <div>{{ restap }}</div>
  </div>
</template>

<script>
import { apiService } from "@/shared/services";

export default {
  name: "Login",
  data() {
    return {
      restap: "test"
    };
  },
  methods: {
    testApi() {
      this.$store.dispatch("authentication/logIn", {
        username: "admin@theater-purpur.ch",
        password: "abc"
      });
      this.restap = "Done";
    },
    testApiWrong() {
      this.$store.dispatch("authentication/logIn", {
        username: "admin@theater-purpur.ch",
        password: "abcd"
      });
      this.restap = "Done Wrong";
    }
  }
};
</script>

<style scoped></style>
