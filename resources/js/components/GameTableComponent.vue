<template>
    <div>
        <b-table striped hover :fields="fields" :items="items">
            <!-- Optional default data cell scoped slot -->
            <template #cell(index)="data">
                {{ data.index + 1 }}
            </template>

            <template #cell(game)="row">
                <b-button
                    size="sm"
                    @click="addGame(row.item.user_id)"
                    class="mr-1"
                >
                    New Game
                </b-button>
                <b-button
                    size="sm"
                    @click="startGame(row.item.user_id)"
                    class="mr-1"
                >
                    Start Game
                </b-button>
            </template>
        </b-table>
    </div>
</template>

<script>
export default {
    name: "Basic",
    props: ["currentUsers"],
    mounted() {
        Echo.private("game").listen("NewGame", e => {
            //update user to show game button
            console.log(e.id);
        });
    },
    created() {
        //
        this.addUserFields();
    },
    methods: {
        addGame(user) {
            console.log(user);
            axios.post("/game", { id: +user }).then(response => {
                console.log(response.data);
            });
            console.log();
        },

        addUserFields() {
            //add this into db query
            for (var i = 0; i < this.items.length; i++) {
                this.items[i].pending = false; // Add "total": 2 to all objects in array
            }
        }
    },
    data() {
        return {
            fields: [
                // A virtual column that doesn't exist in items
                "index",
                "user_id",
                "name",
                "game"
            ],
            items: JSON.parse(this.currentUsers)
        };
    }
};
</script>
