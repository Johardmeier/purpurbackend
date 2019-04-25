//add  v-sortable="sortableOptions" to <b-table>
//where sortableOptions = {options as in ithub sortableJS}
// then add   directives: { sortable },
import Sortable from "sortablejs";

const createSortableTable = function(el, binding, vnode) {
  const table = el.querySelector("table");
  table._sortable = Sortable.create(table.querySelector("tbody"), {
    ...binding.value,
    onEnd: ev => {
      const data = vnode.componentOptions.propsData["data"];
      if (data) {
        let item = data.splice(ev.oldIndex, 1)[0];
        data.splice(ev.newIndex, 0, item);
        vnode.key++;
      }
    }
  });
};
const destroySortableTable = function(el) {
  el.querySelector("table")._sortable.destroy();
};

export const sortable = {
  name: "sortable",
  bind(el, binding, vnode) {
    createSortableTable(el, binding, vnode);
  },
  update(el, binding, vnode) {
    destroySortableTable(el);
    createSortableTable(el, binding, vnode);
  },
  unbind(el) {
    destroySortableTable(el);
  }
};
