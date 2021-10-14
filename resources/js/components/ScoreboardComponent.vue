<template>
    <div class="col-md-12">
        <div
            class="row rounded"
            v-for="item in this.score"
            :key="item.playerId"
            v-bind:class="{ active: item.playerId === playerTurn }"
        >
            <div class="col-md-6 scoreboard__name">
                {{ item.name }} ({{ item.playerId }})
            </div>

            <div class="col-md-6 scoreboard__score">
                {{ item.score }}
            </div>
            <div class="col-md-12 scoreboard__name">
                <b-progress
                    :value="(item.score / scoreLimit) * 100"
                    variant="info"
                    :striped="true"
                ></b-progress>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["score", "playerTurn", "scoreLimit"],
};
</script>
