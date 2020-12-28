<template>
  <div>
    <div class="card">
      <div class="card-header">
        <span> Commands </span>
        <div class="float-right">
          <v-btn color="primary" dark @click="addForm.dialog = true"> Add </v-btn>
        </div>
      </div>

      <div class="card-body">
        <v-data-table
          :headers="headers"
          :items="commands"
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
    <!-- Add command modal window -->
    <v-dialog v-model="addForm.dialog" max-width="600">
      <v-card>
        <v-card-title class="headline"> Create command </v-card-title>

        <v-card-subtitle>
          Input here your bash command settings and object device to run it on.
        </v-card-subtitle>

        <v-card-text>
          <v-text-field v-model="addForm.name" label="Name" required></v-text-field>
          <v-text-field v-model="addForm.content" label="Content" required></v-text-field>
          <v-text-field v-model="addForm.description" label="Description" required></v-text-field>
          <v-radio-group v-model="addForm.input">
            <template v-slot:label>
              <div>Does the command needs string input?</strong></div>
            </template>
            <v-radio
              :label="`Yes`"
              :value="1"
            ></v-radio>
            <v-radio
              :label="`No`"
              :value="0"
            ></v-radio>
          </v-radio-group>
          <v-select
            v-model="addForm.objectId"
            :items="objects"
            label="Computer"
        ></v-select>
        </v-card-text>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="green darken-1" text v-on:click="sendAddForm()">
            Add
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <!-- Edit command modal window -->
    <v-dialog v-model="editForm.dialog" max-width="600">
      <v-card>
        <v-card-title class="headline"> Edit command </v-card-title>

        <v-card-subtitle>
          Input here your command settings and object device to run it on.
        </v-card-subtitle>

        <v-card-text>
          <v-text-field v-model="editForm.name" label="Name" required></v-text-field>
          <v-text-field v-model="editForm.content" label="Content" required></v-text-field>
          <v-text-field v-model="editForm.description" label="Description" required ></v-text-field>
          <v-radio-group v-model="editForm.input" required>
            <template v-slot:label>
              <div>Does the command needs string input?</strong></div>
            </template>
            <v-radio
              :label="`Yes`"
              :value="1"
            ></v-radio>
            <v-radio
              :label="`No`"
              :value="0"
            ></v-radio>
          </v-radio-group>
          <v-select
            v-model="editForm.objectId"
            :items="objects"
            label="Computer"
            required
        ></v-select>
        </v-card-text>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="green darken-1" text v-on:click="sendEditForm()">
            Save
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <!-- Edit command modal window -->
    <v-dialog v-model="deleteForm.dialog" max-width="600">
      <v-card>
        <v-card-title class="headline"> Delete command </v-card-title>

        <v-card-subtitle>
          Are you sure to delete the `{{ deleteForm.name }}` command?
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
  name: "CommandsList",
  data() {
    return {
      // List.
      commands: [],
      objects: [],
      headers: [
        {
          text: 'Name',
          align: 'start',
          sortable: false,
          value: 'name',
        },
        { text: 'Description', sortable: false, value: 'description' },
        { text: 'Input', sortable: false, value: 'input' },
        { text: 'Object', sortable: false, value: 'object.name' },
        { text: '', sortable: false, value: 'actions' },
      ],

      // Add form.
      addForm: {
        dialog: false,
        name: "",
        content: "",
        description: "",
        input: 0,
        objectId: {},
      },

      // Edit form.
      editForm: {
        dialog: false,
        id: 0,
        name: "",
        content: "",
        description: "",
        input: 0,
        objectId: {},
      },
      
      // Delete form
      deleteForm: {
        dialog: false,
        name: "",
        id: "",
      },

      // Failed notification.
      snackbar: false,
      text: `Action failed. Try again later.`,
    };
  },

  created() {
    this.getCommands();
    this.getObjects();
  },

  methods: {
    /**
     * Get all user's commands.
     */
    getCommands() {
      axios
        .get("/commands")
        .then((response) => {
          this.commands = response.data.data;
        })
        .catch((error) => {
          console.error(error);
        })
        .finally(() => {});
    },

    /**
     * Get all user's objects.
     */
    getObjects() {
      axios
        .get("/objects")
        .then((response) => {
          this.objects = response.data.data.map((el) => {
            return {
              text: el.name,
              value: el.id,
            }
          });
        })
        .catch((error) => {
          console.error(error);
        })
        .finally(() => {});
    },

    /**
     * Send Add Command Form.
     */
    sendAddForm() {
      axios
        .post("/command", {
          name: this.addForm.name,
          content: this.addForm.content,
          description: this.addForm.description,
          input: this.addForm.input,
          object_id: this.addForm.objectId,
        })
        .then((response) => {
          if (response.data.success) {
            // Push to Commands.
            this.commands.push(response.data.command);
            // Reset values.
            this.addForm.name = "";
            this.addForm.content = "";
            this.addForm.description = "";
            this.addForm.input = 0;
            this.addForm.objectId = {};
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
     * Send Edit Command Form.
     */
    sendEditForm() {
      axios
        .put("/command/"+this.editForm.id, {
          name: this.editForm.name,
          content: this.editForm.content,
          description: this.editForm.description,
          input: this.editForm.input,
          object_id: this.editForm.objectId,
        })
        .then((response) => {
          if (response.data.data.success) {
            // Replace in Commands.
            let i = this.commands.map(item => item.id).indexOf(response.data.data.command.id);
            Object.assign(this.commands[i], response.data.data.command)
            // Reset values.
            this.editForm.name = "";
            this.editForm.content = "";
            this.editForm.description = "";
            this.editForm.input = 0;
            this.editForm.objectId = {};
          } else {
            this.snackbar = true;
          }
        })
        .catch((error) => {
          console.error(error);
        })
        .finally(() => {
          console.log(this.commands);
          // Close modal.
          this.editForm.dialog = false;
        });
    },

    /**
     * Send Delete Object Form.
     */
    sendDeleteForm() {
      axios
        .delete("/command/"+this.deleteForm.id)
        .then((response) => {
          if (response.data.data.success) {
            // Remove from Commands.
            let i = this.commands.map(item => item.id).indexOf(response.data.data.command.id);
            this.commands.splice(i, 1)
            // Reset values.
            this.deleteForm.id = "";
            this.deleteForm.name = "";
          } else {
            this.snackbar = true;
          }
        })
        .catch((error) => {
          console.error(error);
        })
        .finally(() => {
          // Close modal.
          this.deleteForm.dialog = false;
        });
    },

    /**
     * Open Edit object modal window.
     */
    setEditForm(item) {
      // Find  current item in Commands.
      let index = this.commands.indexOf(item);
      let command = Object.assign({}, item);
      // Set values.
      this.editForm.id = command.id;
      this.editForm.name = command.name;
      this.editForm.content = command.content;
      this.editForm.description = command.description;
      this.editForm.input = command.input;
      this.editForm.objectId = command.object.id;
      // Show modal.
      this.editForm.dialog = true;
    },

    setDeleteForm(item) {
      // Find current item in commands.
      let index = this.commands.indexOf(item);
      let command = Object.assign({}, item);
      // Set values.
      this.deleteForm.id = command.id;
      this.deleteForm.name = command.name;
      // Show modal.
      this.deleteForm.dialog = true;
    }
  },
};
</script>