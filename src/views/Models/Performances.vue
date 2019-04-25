<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
  <div>
    <!--<model-table modelName="Language" :columns="columns" :filterfunction="filterfunction">-->
    <model-table modelName="Language" :columns="columns">
      <template v-slot:head>TODO:: Aufführungen</template>
      <!--<template v-slot:actionButtons></template>-->
      <!--<template v-slot:name="{ row }">{{ row.name }}</template>-->
      <template v-slot:editor="{ editData }">
        <performance-edit></performance-edit>
      </template>
    </model-table>
  </div>
</template>

<script lang="ts">
import Vue, { Component } from "vue";
import { apiService } from "@/shared/services";
// @ts-ignore
import { Toast } from "buefy/dist/components/toast";
import ModelTable from "@/views/Models/common/ModelTable.vue";
import PerformanceEdit from "@/views/Models/PerformanceEdit.vue";

export default Vue.extend({
  components: {
    PerformanceEdit,
    ModelTable
  },
  data() {
    return {
      columns: [
        {
          field: "id",
          label: "ID",
          width: "40",
          numeric: true,
          sortable: true,
          visible: false
        },
        {
          field: "name",
          label: "Sprache"
        },
        {
          field: "short",
          label: "Kürzel",
          sortable: true,
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
