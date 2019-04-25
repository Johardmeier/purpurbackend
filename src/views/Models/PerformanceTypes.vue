<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
  <div>
    <!--<model-table modelName="Language" :columns="columns" :filterfunction="filterfunction">-->
    <model-table modelName="PerformanceType" :columns="columns">
      <template v-slot:head>Aufführungstyp</template>
      <!--<template v-slot:actionButtons></template>-->
      <template v-slot:remarks="{ row }">{{ row.remarks | shorten }}</template>
      <template v-slot:editor="{ editData }">
        <performance-type-edit :editData="editData" modelName="PerformanceType"></performance-type-edit>
      </template>
    </model-table>
  </div>
</template>

<script lang="ts">
import Vue, { Component } from "vue";
// @ts-ignore
import { Toast } from "buefy/dist/components/toast";
import ModelTable from "@/views/Models/common/ModelTable.vue";
import PerformanceTypeEdit from "@/views/Models/PerformanceTypeEdit.vue";

export default Vue.extend({
  components: {
    PerformanceTypeEdit,
    ModelTable
  },
  data() {
    return {
      columns: [
        {
          field: "value",
          label: "Typ"
        },
        {
          field: "remarks",
          label: "Bemerkung",
          sortable: false
        }
      ]
    };
  },
  filters: {
    shorten: function (value: string, max=50) {
      return value.length > max ? value.substring(0, 46) + "..." : value;
    }
  },
  computed: {},
  methods: {
    filterfunction: (model: any) => {
      return model.id > 2;
    }
  },
  created() {}
});
</script>

<style scoped></style>
