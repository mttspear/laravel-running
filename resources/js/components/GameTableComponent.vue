<template>
    <div>
        <b-table striped hover :fields="fields" :items="items">
            <!-- Optional default data cell scoped slot -->
            <template #cell(index)="data">
                {{ data.index + 1 }}
            </template>

            <template #cell(game)="row">
                <b-button
                    v-if="item.status === 'pending'"
                    size="sm"
                    @click="startGame(row.item.user_id)"
                    class="mr-1"
                >
                    Start Game
                </b-button>
                <b-button
                    v-else
                    size="sm"
                    @click="addGame(row.item.user_id)"
                    class="mr-1"
                >
                    New Game
                </b-button>
            </template>
        </b-table>
    </div>
</template>

<script>
export default {
    name: "GameTable",
    props: ["currentUsers"],
    mounted() {
        Echo.private("game." + this.authUser.id).listen(
            "UserEvent",
            (response) => {
                console.log("here");
                this.items = JSON.parse(response.data.currentUsers);
            }
        );
    },
    created() {
        this.addUserFields();
    },
    methods: {
        addGame(user) {
            axios.post("/game", { id: +user }).then((response) => {
                console.log("response");
                console.log(JSON.parse(response.data.currentUsers));
                this.items = JSON.parse(response.data.currentUsers);
            });
        },
        startGame(game) {
            console.log(game);
            axios.post("/start-game", { id: +game }).then((response) => {
                console.log(response.data);
                this.items = JSON.parse(response.data.currentUsers);
            });
            console.log();
        },
        addUserFields() {
            //add this into db query
            for (var i = 0; i < this.items.length; i++) {
                this.items[i].pending = false;
            }
        },
    },
    data() {
        return {
            fields: [
                // A virtual column that doesn't exist in items
                "index",
                "user_id",
                "name",
                "game",
            ],
            items: JSON.parse(this.currentUsers),
        };
    },
};
</script>
