<template>
  <div>
    <div class="card">
      <div class="card-header">
        <span> Objects </span>
        <div class="float-right">
          <v-btn color="primary" dark @click="addForm.dialog = true"> Add </v-btn>
        </div>
      </div>

      <div class="card-body">
        <v-data-table
          :headers="headers"
          :items="objects"
          class="elevation-1"
        >
          <template v-slot:item.actions="{ item }">
            <v-icon
              small
              class="mr-2"
              @click="setEditForm(item)"
            >
              mdi-pencil
            </v-icon>
            <v-icon
              small
              @click="setDeleteForm(item)"
            >
              mdi-delete
            </v-icon>
          </template>
        </v-data-table>
      </div>
    </div>
    <!-- Add object modal window -->
    <v-dialog v-model="addForm.dialog" max-width="600">
      <v-card>
        <v-card-title class="headline"> Create object </v-card-title>

        <v-card-subtitle>
          Input here your new object's settings for future connections. The
          object may be a RaspberryPi device or any other Unix-based computer.
        </v-card-subtitle>

        <v-card-text>
          <v-text-field v-model="addForm.name" label="Name" required></v-text-field>
          <v-text-field v-model="addForm.ip" label="IP" required></v-text-field>
          <v-text-field v-model="addForm.username" label="Username" required></v-text-field>
          <v-text-field v-model="addForm.port" label="Port" required></v-text-field>
          <v-text-field v-model="addForm.keypass" label="Password" required></v-text-field>
        </v-card-text>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="green darken-1" text v-on:click="sendAddForm()">
            Add
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <!-- Edit object modal window -->
    <v-dialog v-model="editForm.dialog" max-width="600">
      <v-card>
        <v-card-title class="headline"> Edit object </v-card-title>

        <v-card-subtitle>
          Input here your object's settings for future connections.
        </v-card-subtitle>

        <v-card-text>
          <v-text-field v-model="editForm.name" label="Name" required></v-text-field>
          <v-text-field v-model="editForm.ip" label="IP" required></v-text-field>
          <v-text-field v-model="editForm.username" label="Username" required ></v-text-field>
          <v-text-field v-model="editForm.port" label="Port" required></v-text-field>
          <v-text-field v-model="editForm.keypass" label="Password" required></v-text-field>
        </v-card-text>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="green darken-1" text v-on:click="sendEditForm()">
            Save
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <!-- Edit object modal window -->
    <v-dialog v-model="deleteDialog" max-width="600">
      <v-card>
        <v-card-title class="headline"> Delete object </v-card-title>

        <v-card-subtitle>
          Are you sure to delete the {{ deleteName }} object?
        </v-card-subtitle>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="green darken-1" text v-on:click="sendDeleteForm()">
            Remove
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <!-- Failed action notification -->
    <v-snackbar v-model="snackbar">
      {{ text }}

      <template v-slot:action="{ attrs }">
        <v-btn color="red" text v-bind="attrs" @click="snackbar = false">
          Close
        </v-btn>
      </template>
    </v-snackbar>
  </div>
</template>

<script>
import { mdiDotsVertical } from "@mdi/js";

export default {
  name: "ObjectsList",
  data() {
    return {
      // List.
      objects: [],
      headers: [
        {
          text: 'Name',
          align: 'start',
          sortable: false,
          value: 'name',
        },
        { text: 'Connection', sortable: false, value: 'details' },
        { text: '', sortable: false, value: 'actions' },
      ],

      // Add form.
      addForm: {
        dialog: false,
        name: "",
        ip: "",
        username: "",
        port: "",
        keypass: "",
      },

      // Edit form.
      editForm: {
        dialog: false,
        id: 0,
        name: "",
        ip: "",
        username: "",
        port: "",
        keypass: "",
      },
      
      // Delete form
      deleteDialog: false,
      deleteName: "",
      deleteId: "",


      // Failed notification.
      snackbar: false,
      text: `Action failed. Try again later.`,
    };
  },

  created() {
    this.getObjects();
  },

  methods: {
    /**
     * Get all user's objects.
     */
    getObjects() {
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

    /**
     * Send Add Object Form.
     */
    sendAddForm() {
      axios
        .post("/object", {
          name: this.addForm.name,
          ip: this.addForm.ip,
          username: this.addForm.username,
          port: this.addForm.port,
          keypass: this.addForm.keypass,
        })
        .then((response) => {
          if (response.data.success) {
            // Push to Objects.
            this.objects.push(response.data.object);

            // Reset values.
            this.addForm.name = "";
            this.addForm.ip = "";
            this.addForm.username = "";
            this.addForm.port = "";
            this.addForm.keypass = "";
          } else {
            this.snackbar = true;
          }
        })
        .catch((error) => {
          console.error(error);
        })
        .finally(() => {
          // Close modal.
          this.addForm.dialog = false;
        });
    },

    /**
     * Send Edit Object Form.
     */
    sendEditForm() {
      axios
        .put("/object/"+this.editForm.id, {
          name: this.editForm.name,
          ip: this.editForm.ip,
          username: this.editForm.username,
          port: this.editForm.port,
          keypass: this.editForm.keypass,
        })
        .then((response) => {
          if (response.data.data.success) {
            // Replace in Objects.
            let i = this.objects.map(item => item.id).indexOf(response.data.data.object.id);
            Object.assign(this.objects[i], response.data.data.object)
            // Reset values.
            this.editForm.name = "";
            this.editForm.ip = "";
            this.editForm.username = "";
            this.editForm.port = "";
            this.editForm.keypass = "";
          } else {
            this.snackbar = true;
          }
        })
        .catch((error) => {
          console.error(error);
        })
        .finally(() => {
          console.log(this.objects);
          // Close modal.
          this.editForm.dialog = false;
        });
    },

    /**
     * Send Delete Object Form.
     */
    sendDeleteForm() {
      axios
        .delete("/object/"+this.deleteId)
        .then((response) => {
          if (response.data.data.success) {
            // Remove from Objects.
            let i = this.objects.map(item => item.id).indexOf(response.data.data.object.id);
            this.objects.splice(i, 1)
            // Reset values.
            this.deleteId = "";
            this.deleteName = "";
          } else {
            this.snackbar = true;
          }
        })
        .catch((error) => {
          console.error(error);
        })
        .finally(() => {
          // Close modal.
          this.deleteDialog = false;
        });
    },

    /**
     * Open Edit object modal window.
     */
    setEditForm(item) {
      // Find in this.objects current item.
      let index = this.objects.indexOf(item);
      let object = Object.assign({}, item);
      // Set values.
      this.editForm.id = object.id;
      this.editForm.name = object.name;
      this.editForm.ip = object.ip;
      this.editForm.username = object.username;
      this.editForm.port = object.port;
      this.editForm.keypass = object.keypass;
      // Show modal.
      this.editForm.dialog = true;
    },

    setDeleteForm(item) {
      // Find in this.objects current item.
      let index = this.objects.indexOf(item);
      let object = Object.assign({}, item);
      // Set values.
      this.deleteId = object.id;
      this.deleteName = object.name;
      // Show modal.
      this.deleteDialog = true;
    }
  },
};
</script>