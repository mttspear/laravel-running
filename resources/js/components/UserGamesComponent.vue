<template>
    <div>
        <b-table striped hover :items="items"> </b-table>
    </div>
</template>

<script>
export default {
    name: "UserGames",
    props: ["games"],
    mounted() {},
    created() {},
    methods: {},
    data() {
        return {
            items: JSON.parse(this.games),
        };
    },
};
</script>
