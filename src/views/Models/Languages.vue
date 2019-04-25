<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
  <div>
    <!--<model-table modelName="Language" :columns="columns" :filterfunction="filterfunction">-->
    <model-table modelName="Language" :columns="columns">
      <template v-slot:head>Sprachen</template>
      <!--<template v-slot:actionButtons></template>-->
      <!--<template v-slot:name="{ row }">{{ row.name }}</template>-->
      <template v-slot:editor="{ editData }">
        <language-edit :editData="editData" modelName="Language"></language-edit>
      </template>
    </model-table>
  </div>
</template>

<script lang="ts">
import Vue, { Component } from "vue";
// @ts-ignore
import { Toast } from "buefy/dist/components/toast";
import ModelTable from "@/views/Models/common/ModelTable.vue";
import LanguageEdit from "@/views/Models/LanguageEdit.vue";

export default Vue.extend({
  components: {
    LanguageEdit,
    ModelTable
  },
  data() {
    return {
      columns: [
        {
          field: "name",
          label: "Sprache"
        },
        {
          field: "short",
          label: "Kürzel",
          sortable: true
        }
      ]
    };
  },
  computed: {},
  methods: {
    filterfunction: (model: any) => {
      return model.id>2;
    }
  },
  created() {}
});
</script>

<style scoped></style>
