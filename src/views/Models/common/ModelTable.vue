<template>
  <div>
    <!--// TODO:: Streamline (remove) element styling and NavBar-->
    <div
      class="has-shadow is-bordered is-flex"
      style="border-bottom-color: #d7c071; border-bottom-width: 2px; border-bottom-style: solid"
    >
      <div class="is-size-3" style="">
        <h1>
          <slot name="head">{{ modelName }}</slot>
        </h1>
      </div>
      <!--TODO:: Align temp text to bottom - beautify this-->
      <div v-if="loading" style="align-content: baseline">
        ... Daten werden geladen ...
      </div>
      <div class="buttons is-pulled-right" style="margin-left:auto;">
        <slot name="actionButtons"></slot>
        <span class="button is-success" @click="newModel()">
          <span class="icon is-small"><i class="fas fa-plus"></i></span>
          <span>Neu</span>
        </span>
      </div>
    </div>
    <div v-if="loading">
      <b-loading
        :is-full-page="false"
        :active.sync="loading"
        :can-cancel="false"
      ></b-loading>
    </div>
    <div v-else>
      <b-field
        style="justify-content: flex-end; margin-top: 10px; margin-bottom: -30px; overflow:visible"
      >
        <b-input
          placeholder="Filter..."
          type="search"
          icon-pack="fas"
          icon="filter"
          size="is-small"
          v-model="filterString"
        >
        </b-input>
        <b-dropdown position="is-bottom-left">
          <span class="button is-small" slot="trigger">
            <i class="fas fa-cog"></i>
          </span>
          <b-dropdown-item v-for="col in modelColumns" :key="col.field">
            <b-checkbox v-model="col.visible" @input="tableKey += 1">
              {{ col.label }}
            </b-checkbox>
          </b-dropdown-item>
        </b-dropdown>
        <b-tooltip label="inkl. Versteckte" position="is-left">
          <span
            class="button is-small"
            :class="{ 'is-success': showInactive }"
            @click="showInactive = !showInactive"
          >
            <i class="far fa-eye"></i>
          </span>
        </b-tooltip>
      </b-field>
      <b-table :data="modelData" :key="tableKey">
        <template slot-scope="props">
          <BTableColumn
            v-for="column in modelColumns"
            v-bind="column"
            :key="column.field || column.customKey"
          >
            <slot
              :name="column.field || column.customKey"
              :row="props.row"
              :column="column"
            >
              {{ props.row[column.field] | applyFormat(column) }}
            </slot>
          </BTableColumn>
          <b-table-column width="150" custom-key="buttons" numeric>
            <div class="buttons has-addons is-right">
              <b-tooltip label="Bearbeiten" position="is-left">
                <span class="button is-small" @click="edit(props.row)">
                  <i class="far fa-edit"></i>
                </span>
              </b-tooltip>
              <b-tooltip label="Verstecken" position="is-bottom">
                <span class="button is-small" @click="toggleActive(props.row)">
                  <i class="far fa-eye" v-if="props.row.active"></i>
                  <i class="far fa-eye-slash" v-else></i>
                </span>
              </b-tooltip>
            </div>
          </b-table-column>
        </template>
      </b-table>
      <b-modal :active.sync="showEditForm" has-modal-card :canCancel="false" width="100%" >
        <!-- width="100%" necessary to center the form, when width>960-->
        <slot name="editor" :editData="editData"></slot>
      </b-modal>
    </div>
  </div>
</template>

<script>
import moment from "moment";
export default {
  name: "model-table",
  data() {
    return {
      tableKey: 0,
      filterString: "",
      showInactive: false,
      showEditForm: false,
      editData: {},
      hasCustomActionButton: false,
      loading: true
    };
  },
  props: {
    columns: {
      type: Array,
      default: () => []
    },
    modelName: {
      type: String,
      default: ""
    },
    filterfunction: {
      type: Function
    }
  },
  watch: {},
  computed: {
    modelData() {
      //console.log('calc modelData - loaded:',!this.loading, this.columns);
      let allModels = this.$store.getters["models/model"](this.modelName);
      if (!allModels) return;
      let needle = this.filterString.toLowerCase();
      let mData = allModels.filter(a => {
        let fltr =
          needle === ""
            ? true // TODO:: iterate through 'filtercolumns'
            : a.name.toLowerCase().includes(needle) ||
              a.url.toLowerCase().includes(needle);
        let sact = this.showInactive ? true : a.active;
        return fltr && sact;
      });
      return this.filterfunction ? mData.filter(this.filterfunction) : mData;
    },
    modelColumns() {
      //console.log('calc modelColumns - loaded:',!this.loading, this.columns);
      let mAll = this.$store.getters["models/model"](this.modelName);
      let mKeys = mAll && mAll[0] ? Object.keys(mAll[0]) : [];
      let defaults = [
        {
          field: "id",
          label: "ID",
          width: "40",
          numeric: true,
          sortable: true,
          visible: false
        },
        {
          field: "created_at",
          label: "Erstellt",
          width: "80",
          meta: { format: "date" },
          sortable: true,
          visible: false
        }
      ].filter(
        ({ field }) =>
          !field ||
          (!this.columns.find(
            o => !o.field || o.field.toLowerCase() === field.toLowerCase()
          ) &&
            mKeys.find(o => o.toLowerCase() === field.toLowerCase()))
      );
      return [...defaults, ...this.columns].map(item =>
        Object.assign({ visible: true, sortable: !!item.field }, item)
      );
    }
  },
  filters: {
    applyFormat(value, field) {
      let format = (field.meta && field.meta.format) || "default";
      switch (format) {
        case "date":
          return moment(value).format("DD.MM.YY");
        default:
          return value;
      }
    }
  },
  methods: {
    toggleActive(row) {
      row.active = !row.active;
      // noinspection JSIgnoredPromiseFromCall
      this.$store.dispatch("models/modify", {
        model: this.modelName,
        data: row
      });
    },
    edit(row) {
      this.editData = row;
      this.showEditForm = true;
    },
    newModel() {
      this.edit({});
    }
  },
  created() {
    //TODO:: ev. läuft das nicht, weil Komponente wiederverwendet...
    this.$store.dispatch("models/load", { model: this.modelName }).then(() => {
      this.loading = false;
      //console.log('loaded');
    });
  }
};
</script>

<style scoped></style>
