<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
  <model-edit-form :editData="editData" :modelName="modelName" @close="$parent.close()">
    <template v-slot="{ data, currentModel }">
      <b-field label="Name">
        <b-input v-model="data.name" placeholder="Schwizerdütsch" required></b-input>
      </b-field>

      <detail-models-table
        modelName="PlayCapacityrow"
        linkField="play_capacity_id"
        :parentID="data.id"
        :parentModel="currentModel"
        :tableColumns="tableColumns"
        :emptyRow="emptyRow"
      >
        <template v-slot:description="{ row, enabled }">
          <b-field>
            <b-input
              placeholder="Beschreibung"
              size="is-small"
              icon="comment"
              icon-pack="far"
              :disabled="!enabled"
              v-model="row.description"
            >
            </b-input>
          </b-field>
        </template>

        <template v-slot:adults="{ row, enabled }">
          <b-field style="width: 80px">
            <b-input
              placeholder="Anzahl"
              type="number"
              size="is-small"
              icon="user-tie"
              icon-pack="fas"
              :disabled="!enabled"
              v-model="row.adults"
            >
            </b-input>
          </b-field>
        </template>
        <template v-slot:juniors="{ row, enabled }">
          <b-field style="width: 80px">
            <b-input
              placeholder="Anzahl"
              type="number"
              size="is-small"
              icon="child"
              icon-pack="fas"
              :disabled="!enabled"
              v-model="row.juniors"
            >
            </b-input>
          </b-field>
        </template>
      </detail-models-table>

      <b-field label="Bemerkungen">
        <b-input v-model="data.remarks" type="textarea" placeholder=""></b-input>
      </b-field>
    </template>
  </model-edit-form>
</template>

<script lang="ts">
import Vue, { Component } from "vue";
// @ts-ignore
import { Toast } from "buefy/dist/components/toast";
import DetailModelsTable from "@/views/Models/common/DetailModelsTable.vue";
import ModelEditForm from "@/views/Models/common/ModelEditForm.vue";

export default Vue.extend({
  name: "PlayCapacityEdit",
  components: { DetailModelsTable, ModelEditForm },
  props: {
    editData: Object,
    modelName: String
  },
  data() {
    return {
      tableColumns: [
        {
          field: "description",
          label: "Name"
        },
        {
          field: "juniors",
          label: "Kleine",
          centered: true
        },
        {
          field: "adults",
          label: "Grosse",
          centered: true
        }
      ],
      emptyRow: {
        adults: 0,
        juniors: 0,
        description: ""
      }
    };
  },
  computed: {},
  methods: {},
  created() {},
  mounted() {},
  updated() {}
});
</script>

<style></style>
