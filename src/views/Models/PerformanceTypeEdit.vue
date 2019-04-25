<template>
  <model-edit-form :editData="editData" :modelName="modelName" @close="$parent.close()">
    <template v-slot="{ data, currentModel }">
      <b-field label="Typ">
        <b-input v-model="data.value" placeholder="Regulär" required></b-input>
      </b-field>
      <b-field label="Bemerkung">
        <b-input maxlength="200" type="textarea" v-model="data.remarks" placeholder=""></b-input>
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
  name: "PerformanceTypeEdit",
  components: { ModelEditForm },
  props: {
    editData: Object,
    modelName: String
  }
});
</script>
<style scoped></style>
