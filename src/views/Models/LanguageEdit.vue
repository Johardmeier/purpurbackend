<template>
  <model-edit-form :editData="editData" :modelName="modelName" @close="$parent.close()">
    <template v-slot="{ data, currentModel }">
      <b-field label="Name">
        <b-input v-model="data.name" placeholder="Schwizerdüütsch" required></b-input>
      </b-field>
      <b-field label="Kürzel">
        <b-input maxlength="5" v-model="data.short" placeholder="sd"></b-input>
      </b-field>
    </template>
  </model-edit-form>
</template>

<script lang="ts">
import Vue, { Component } from "vue";
// @ts-ignore
import { Toast } from "buefy/dist/components/toast";
import ModelEditForm from "@/views/Models/common/ModelEditForm.vue";

export default Vue.extend({
  name: "LanguageEdit",
  components: { ModelEditForm },
  props: {
    editData: Object,
    modelName: String
  }
});
</script>
<style scoped></style>
