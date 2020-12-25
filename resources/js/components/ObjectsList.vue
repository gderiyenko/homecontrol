<template>
  <v-simple-table>
    <template v-slot:default>
      <thead>
        <tr>
          <th class="text-left">Name</th>
          <th class="text-left">Connection</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in objects" :key="item.name">
          <td>{{ item.name }}</td>
          <td> {{ item.details }} </td>
          <td class="text-right">
            <v-icon> mdi-dots-vertical</v-icon>
          </td>
        </tr>
      </tbody>
    </template>
  </v-simple-table>
</template>

<script>
import { mdiDotsVertical } from "@mdi/js";

export default {
  name: "ObjectsList",
  data() {
    return {
      objects: [],
    };
  },

  created() {
    this.getObjects();
  },

  methods: {
    onResponse(result) {
      console.log(result);
      this.objects = result;
    },
    getObjects() {
      let that = this;
      axios
        .get("/objects")
        .then((response) => {
          this.objects = response.data.data;
        })
        .catch((error) => {
          console.error(error);
        })
        .finally(() => {});
    },
  },
};
</script>