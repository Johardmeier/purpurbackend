<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
  <section>
    <b-table
      :data="tableData"
      class="editableTable"
      v-sortable="sortableOptions"
      custom-row-key="id"
    >
      <template v-slot:header="props">
        {{ props.column.label }}
      </template>
      <template slot-scope="props">
        <b-table-column custom-key="buttons-left" numeric>
          <span class="icon sortHandle"><i class="fas fa-sort"></i></span>
        </b-table-column>

        <BTableColumn
          v-for="column in tableColumns"
          v-bind="column"
          :key="column.field || column.customKey"
        >
          <slot
            :name="column.field || column.customKey"
            :row="props.row"
            :column="column"
            :enabled="editRow === props.index"
          >
          </slot>
        </BTableColumn>

        <b-table-column custom-key="buttons-right" numeric>
          <!--<div class="buttons has-addons is-right">-->
          <div class="buttons has-addons is-right table-action-buttons">
            <b-tooltip label="Bearbeiten" position="is-left">
              <span
                class="button is-small"
                :class="{ 'is-success': editRow === props.index }"
                @click="editTableRow(props.index)"
              >
                <i class="far fa-edit"></i>
              </span>
            </b-tooltip>
            <b-tooltip label="Löschen" position="is-bottom">
              <span class="button is-small" @click="removeTableRow(props.index)">
                <i class="fas fa-window-close"></i>
              </span>
            </b-tooltip>
          </div>
        </b-table-column>
      </template>
    </b-table>
    <div style="margin-left: 30px ; margin-right: 73px">
      <a class="button is-small" @click="addTableRow" style="width: 100%">+</a>
    </div>
  </section>
</template>

<script>
import { sortable } from "@/shared/helpers/sortable";
export default {
  name: "detail-models-table",
  directives: { sortable },
  props: {
    modelName: { type: String, required: true },
    parentID: { type: Number, required: true },
    parentModel: { type: String, required: true },
    linkField: { type: String, required: true },
    tableColumns: { type: Array, required: true },
    emptyRow: { type: Object, required: true }
  },
  data() {
    return {
      sortableOptions: {
        chosenClass: "is-chosen",
        ghostClass: "is-ghosted",
        handle: ".sortHandle"
      },
      editRow: -1,
      tableData: [{}],
      tableUpdateKey: 0
    };
  },
  computed: {},
  methods: {
    getTableData() {
      return this.$store.getters["models/model"](this.modelName).filter(
        r => r[this.linkField] === this.parentID
      );
    },
    saveModel() {
      this.$store.dispatch("models/replaceBelongsTo", {
        model: this.modelName,
        data: this.tableData,
        parentId: this.parentID,
        parentModel: this.parentModel
      });
    },
    addTableRow() {
      this.tableData.push({ ...this.emptyRow });
      this.editRow = this.tableData.length - 1;
    },
    editTableRow(row) {
      this.editRow = this.editRow === row ? -1 : row;
    },
    removeTableRow(row) {
      this.tableData.splice(row, 1);
    }
  },
  updated() {},
  mounted() {
    this.tableData = [...this.getTableData()];
    this.$bus.$once("SAVE_MODELEDIT_CHILDREN", () => this.saveModel());
  }
};
</script>

<style>
.is-chosen {
  background-color: #95cad9;
}

.is-sorting {
  background-color: #d9a2d4;
}

.editableTable .table th,
.editableTable .table td {
  padding: 0.1em;
  border: none;
}
.table-action-buttons .button {
  border: transparent solid thin;
}

.table-action-buttons .button:hover {
  border: #95cad9 solid thin;
}
</style>
