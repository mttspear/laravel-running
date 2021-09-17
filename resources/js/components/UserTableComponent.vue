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
                    v-if="row.item.game_id !== null"
                    variant="success"
                    size="sm"
                    @click="startGame(row.item.game_id)"
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
        console.log(this.items);
    },
    methods: {
        addGame(user) {
            console.log(user);
            axios.post("/add-game", { id: +user }).then(response => {
                console.log(response.data);
            });
            console.log();
        },
        startGame(game) {
            console.log(game);
            axios.post("/start-game", { id: +game }).then(response => {
                console.log(response.data);
            });
            console.log();
        }
    },
    data() {
        return {
            fields: [
                // A virtual column that doesn't exist in items
                "index",
                "user_id",
                "name",
                "game_id",
                "status",
                "game"
            ],
            items: JSON.parse(this.currentUsers)
        };
    }
};
</script>
