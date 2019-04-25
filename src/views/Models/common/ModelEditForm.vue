<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
  <form action="">
    <div class="modal-card" style="width: auto">
      <header class="modal-card-head">
        <p class="modal-card-title">{{ currentData.name }}</p>
      </header>
      <section class="modal-card-body">
        <slot :data="currentData" :currentModel="modelName"></slot>
      </section>
      <footer class="modal-card-foot">
        <button class="button" type="button" @click="saveModel">Speichern</button>
        <button class="button" type="button" @click="closeEdit">Abbrechen</button>
      </footer>
    </div>
  </form>
</template>

<script lang="ts">
import Vue, { Component } from "vue";
// @ts-ignore
import { Toast } from "buefy/dist/components/toast";
// @ts-ignore
import eventBus from "@/eventBus";

export default Vue.extend({
  name: "ModelEditForm",
  directives: {},
  components: {},
  props: {
    editData: Object,
    modelName: String
  },
  data() {
    return {
      currentData: { ...this.editData }
    };
  },
  computed: {
    isNew(): boolean { return !this.editData.id; }
  },
  methods: {
    closeEdit() {
      this.$emit("close");
    },
    saveModel() {
      this.$store.dispatch("models/" + (this.isNew ? "new" : "update"), {
        model: this.modelName,
        data: this.currentData
      });
      //@ts-ignore
      this.$bus.$emit("SAVE_MODELEDIT_CHILDREN");
      this.closeEdit();
    }
  },
  created() {},
  mounted() {},
  updated() {}
});
</script>

<style></style>
