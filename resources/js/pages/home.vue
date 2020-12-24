<template>
  <div>
    <v-btn color="primary" dark @click.stop="dialog = true"> Add Object </v-btn>

    <v-dialog v-model="dialog" max-width="600">
      <v-card>
        <v-card-title class="headline"> Create object </v-card-title>

        <v-card-subtitle>
          Input here your new object's settings for future connections. The
          object may be a RaspberryPi device or any other Unix-based computer.
        </v-card-subtitle>

        <v-card-text>
          <v-text-field v-model="name" label="Name" required></v-text-field>
          <v-text-field v-model="ip" label="IP" required></v-text-field>
          <v-text-field v-model="username" label="Username" required ></v-text-field>
          <v-text-field v-model="port" label="Port" required></v-text-field>
          <v-text-field v-model="password" label="password" required></v-text-field>
        </v-card-text>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="green darken-1" text @click="dialog = false">
            Add
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
export default {
  name: "AddObject",
  data() {
    return {
      dialog: false,
    };
  },
};
</script>