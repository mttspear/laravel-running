<template>
    <div>
        <b-table striped hover :fields="fields" :items="items">
            <!-- Optional default data cell scoped slot -->
            <template #cell(index)="data">
                {{ data.index + 1 }}
            </template>

            <template #cell(game)="row">
                <b-button
                    v-if="
                        row.item.status === 'pending' &&
                        row.item.requestor != user.id
                    "
                    variant="success"
                    size="sm"
                    @click="startGame(row.item.game_id)"
                    class="mr-1"
                >
                    Start Game
                </b-button>
                <div
                    v-else-if="
                        row.item.status === 'pending' &&
                        row.item.requestor == user.id
                    "
                ></div>
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
    name: "UserTable",
    props: ["currentUsers", "authUser"],
    mounted() {
        Echo.private("game." + this.authUser.id).listen(
            "UserEvent",
            (response) => {
                this.items = response.data.currentUsers;
            }
        );
    },
    created() {},
    methods: {
        addGame(user) {
            console.log(user);
            axios.post("/add-game", { id: +user }).then((response) => {
                console.log(JSON.parse(response.data.currentUsers));
                this.items = JSON.parse(response.data.currentUsers);
            });
            console.log();
        },
        startGame(game) {
            console.log(game);
            axios.post("/start-game", { id: +game }).then((response) => {
                console.log(response.data);
            });
        },
    },
    data() {
        return {
            fields: ["name", "game_id", "status", "game"],
            items: JSON.parse(this.currentUsers),
            user: this.authUser,
        };
    },
};
</script>
