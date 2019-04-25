<template>
  <section>
    <b-table v-sortable="sortableOptions"
      :data="dataBu"
      custom-row-key="id"
    >

      <template slot-scope="props">
        <b-table-column field="id" label="ID" width="80" numeric>
          <i class="handler1 far fa-eye" @click="sortableOptions.handle = '.handle' + props.row.id"></i> {{ props.row.id }}
        </b-table-column>

        <b-table-column label="handle">
          <i class="far fa-eye" @click="objHandle = 'handle' + props.row.id"></i> {{ props.row.id }}
        </b-table-column>

        <b-table-column field="first_name" label="First Name">
          {{ props.row.first_name }}
        </b-table-column>

        <b-table-column field="last_name" label="Last Name">
          {{ props.row.last_name }}
        </b-table-column>

        <b-table-column field="date" label="Date" centered>
          <span class="tag is-success handler3">
            {{ new Date(props.row.date).toLocaleDateString() }}
          </span>
        </b-table-column>

        <b-table-column label="Gender">
          <b-icon pack="fas"
            :icon="props.row.gender === 'Male' ? 'mars' : 'venus'">
          </b-icon>
          {{ props.row.gender }}
        </b-table-column>
      </template>

    </b-table>
  </section>
</template>

<script>
import { sortable } from "@/shared/helpers/sortable";

export default {
  directives: { sortable },
  methods: {},
  data() {
    return {
      sortableOptions: {
        chosenClass: "is-selected",
        handle: ".handler1"
      },
      dataBu: [
        { 'id': 1, 'first_name': 'Jesse', 'last_name': 'Simmons', 'date': '2016/10/15 13:43:27', 'gender': 'Male' },
        { 'id': 2, 'first_name': 'John', 'last_name': 'Jacobs', 'date': '2016/12/15 06:00:53', 'gender': 'Male' },
        { 'id': 3, 'first_name': 'Tina', 'last_name': 'Gilbert', 'date': '2016/04/26 06:26:28', 'gender': 'Female' },
        { 'id': 4, 'first_name': 'Clarence', 'last_name': 'Flores', 'date': '2016/04/10 10:28:46', 'gender': 'Male' },
        { 'id': 5, 'first_name': 'Anne', 'last_name': 'Lee', 'date': '2016/12/06 14:38:38', 'gender': 'Female' }
      ]
    }
  }
}
</script>

<style scoped>

</style>