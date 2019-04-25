import _Vue from "vue";

import { Toast } from 'buefy/types/components';
//import { Dialog, ModalProgrammatic, LoadingProgrammatic, Toast, Snackbar } from "./components";
//import { ColorModifiers } from "./helpers";

// Adds Buefy method signatures to Vue instance (ie this.$dialog)
declare module 'vue/types/vue' {
  interface Vue {
    $toast: typeof Toast
  }
}

/// <reference path="/vue/types/vue" />

