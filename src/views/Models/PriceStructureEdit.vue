<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
  <model-edit-form :editData="editData" :modelName="modelName" @close="$parent.close()">
    <template v-slot="{ data, currentModel }">
      <b-field label="Name">
        <b-input v-model="data.name" placeholder="Standard" required></b-input>
      </b-field>
      <b-field label="Bemerkungen">
        <b-input v-model="data.remarks" placeholder=""></b-input>
      </b-field>
      <b-field label="Erwachsene">
        <b-input v-model="data.adult_price" placeholder=""></b-input>
      </b-field>
      <b-field label="Kinder">
        <b-input v-model="data.junior_price" placeholder=""></b-input>
      </b-field>
      <h1>Ermässigungen</h1>
      <b-tabs size="is-small" v-model="activeTab">

        <b-tab-item label="Erwachsene" icon="user">
          <detail-models-table
            modelName="PlayPricediscountAdult"
            linkField="pricestructure_id"
            :parentID="data.id"
            :parentModel="currentModel"
            :tableColumns="tableColumns"
            :emptyRow="emptyRow"
          >
            <template v-slot:name="{ row, enabled }">
              <b-field>
                <b-input
                  placeholder="Name"
                  size="is-small"
                  icon="comment"
                  icon-pack="far"
                  :disabled="!enabled"
                  v-model="row.name"
                ></b-input>
              </b-field>
            </template>
            <template v-slot:price="{ row, enabled }">
              <b-field>
                <b-input
                  placeholder="Preis"
                  type="number"
                  size="is-small"
                  icon="comment"
                  icon-pack="far"
                  :disabled="!enabled"
                  v-model="row.price"
                ></b-input>
              </b-field>
            </template>
            <template v-slot:remarks="{ row, enabled }">
              <b-field>
                <b-input
                  placeholder="Bemerkung"
                  size="is-small"
                  icon="comment"
                  icon-pack="far"
                  :disabled="!enabled"
                  v-model="row.remarks"
                ></b-input>
              </b-field>
            </template>
          </detail-models-table>
        </b-tab-item>

        <b-tab-item label="Kinder" icon="user">
          <detail-models-table
            modelName="PlayPricediscountJunior"
            linkField="pricestructure_id"
            :parentID="data.id"
            :parentModel="currentModel"
            :tableColumns="tableColumns"
            :emptyRow="emptyRow"
          >
            <template v-slot:name="{ row, enabled }">
              <b-field>
                <b-input
                  placeholder="Beschreibung"
                  size="is-small"
                  icon="comment"
                  icon-pack="far"
                  :disabled="!enabled"
                  v-model="row.name"
                >
                </b-input>
              </b-field>
            </template>
            <template v-slot:price="{ row, enabled }">
              <b-field>
                <b-input
                  placeholder="Preis"
                  type="number"
                  size="is-small"
                  icon="child"
                  icon-pack="fas"
                  :disabled="!enabled"
                  v-model="row.price"
                ></b-input>
              </b-field>
            </template>
            <template v-slot:remarks="{ row, enabled }">
              <b-field>
                <b-input
                  placeholder="Bemerkung"
                  size="is-small"
                  icon="comment"
                  icon-pack="far"
                  :disabled="!enabled"
                  v-model="row.remarks"
                ></b-input>
              </b-field>
            </template>
          </detail-models-table>
        </b-tab-item>

        <b-tab-item label="Gruppen" icon="user">
          <detail-models-table
            modelName="PlayPricediscountGroup"
            linkField="pricestructure_id"
            :parentID="data.id"
            :parentModel="currentModel"
            :tableColumns="tableColumnsGroup"
            :emptyRow="emptyRowGroup"
          >
            <template v-slot:name="{ row, enabled }">
              <b-field>
                <b-input
                  placeholder="Beschreibung"
                  size="is-small"
                  icon="comment"
                  icon-pack="far"
                  :disabled="!enabled"
                  v-model="row.name"
                >
                </b-input>
              </b-field>
            </template>
            <template v-slot:formula="{ row, enabled }">
              <b-field>
                <b-input
                  placeholder="Formel"
                  size="is-small"
                  icon="comment"
                  icon-pack="far"
                  :disabled="!enabled"
                  v-model="row.formula"
                ></b-input>
              </b-field>
            </template>
            <template v-slot:remarks="{ row, enabled }">
              <b-field>
                <b-input
                  placeholder="Bemerkung"
                  size="is-small"
                  icon="comment"
                  icon-pack="far"
                  :disabled="!enabled"
                  v-model="row.remarks"
                ></b-input>
              </b-field>
            </template>
          </detail-models-table>
        </b-tab-item>
      </b-tabs>
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
  name: "PriceStructureEdit",
  components: { DetailModelsTable, ModelEditForm },
  props: {
    editData: Object,
    modelName: String
  },
  data() {
    return {
      activeTab: 0,
      tableColumns: [
        {
          field: "name",
          label: "Name"
        },
        {
          field: "price",
          label: "Preis"
        },
        {
          field: "remarks",
          label: "Bemerkungen"
        }
      ],
      emptyRow: {
        name: "",
        price: 0,
        remarks: ""
      },
      tableColumnsGroup: [
        {
          field: "name",
          label: "Name"
        },
        {
          field: "formula",
          label: "Formel"
        },
        {
          field: "remarks",
          label: "Bemerkungen"
        }
      ],
      emptyRowGroup: {
        name: "",
        formula: "",
        remarks: ""
      }
    };
  },
  computed: {},
  methods: {}
});
</script>

<style scoped></style>
