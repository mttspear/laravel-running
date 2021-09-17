<template>
    <div class="container">
        <div class="row justify-content-center">
            <flip-countdown
                :deadline="this.currentUserMove.expired + ' utc'"
                :showDays="true"
                :showHours="true"
                :showMinutes="true"
            ></flip-countdown>
            <div class="col-md-6">
                <b-form v-if="renderPickArtist">
                    <b-form-group
                        id="input-group-artist"
                        label="Artist:"
                        label-for="input-artist"
                        description="Search for artist"
                    >
                        <b-form-input
                            id="input-artist"
                            v-model="artistEntered"
                            type="text"
                            placeholder="Artist Name"
                            required
                        ></b-form-input>
                    </b-form-group>
                    <b-button @click="submitArtist()" variant="primary"
                        >Submit</b-button
                    >
                </b-form>

                <b-form v-if="renderArtistOptions">
                    <b-form-group
                        label="Individual radios"
                        v-slot="{ ariaDescribedby }"
                    >
                        <div
                            v-for="artist in artistOptions"
                            v-bind:key="artist.id"
                        >
                            <b-form-radio
                                :value="artist.id"
                                v-model="artistSelected"
                                :aria-describedby="ariaDescribedby"
                                name="artist-options"
                                >{{ artist.title }}</b-form-radio
                            >
                        </div>
                    </b-form-group>
                    <b-button @click="confirmArtist()" variant="primary"
                        >Submit</b-button
                    >
                </b-form>

                <b-form v-if="renderPickSong">
                    <b-form-group
                        id="input-group-1"
                        label="Song:"
                        label-for="input-1"
                        description="Name a song by the singer."
                    >
                        <b-form-input
                            v-model="song"
                            id="input-song"
                            type="text"
                            placeholder="Enter song"
                            required
                        ></b-form-input>
                    </b-form-group>
                    <b-button @click="submitSong()" variant="primary"
                        >Submit</b-button
                    >
                </b-form>
            </div>
            <div class="col-md-6">
                <b-table striped hover :fields="scoreFields" :items="scores">
                </b-table>
            </div>
        </div>
    </div>
</template>

<script>
import FlipCountdown from "vue2-flip-countdown";

export default {
    components: { FlipCountdown },
    props: ["activeGame", "gameScores"],
    computed: {
        pickArtist() {
            //var obj = "undefined";
            //console.log(this.scores);
            //if (this.scores !== null) {
            let obj = this.scores.find((o) => o.answerStatus === "pick-artist");
            //}
            return obj;
        },
        renderPickArtist() {
            if (typeof this.pickArtist !== "undefined") {
                return true;
            } else {
                return false;
            }
        },
        renderArtistOptions() {
            if (this.artistOptions === null) {
                return false;
            } else {
                return true;
            }
        },
        renderPickSong() {
            if (this.renderPickArtist) {
                return false;
            } else {
                return true;
            }
        },
        currentUserMove() {
            let latest = this.scores;
            latest = latest.reduce(function (r, a) {
                return r.created_at > a.created_at ? r : a;
            });
            return latest;
        },
    },
    mounted() {
        console.log(Date.now());
        Echo.private("game").listen("NewGame", (e) => {
            //console.log(e);
        });
    },
    data() {
        return {
            scoreFields: [
                // A virtual column that doesn't exist in items
                "artistName",
                "playerAnswer",
                "answerStatus",
            ],
            game: JSON.parse(this.activeGame),
            scores: JSON.parse(this.gameScores),
            artist: null,
            artistEntered: null,
            artistSelected: null,
            artistOptions: null,
            song: null,
        };
    },
    methods: {
        submitArtist() {
            //console.log(this.artistEntered);
            axios
                .post("/submit-artist", {
                    artist: this.artistEntered,
                })
                .then((response) => {
                    //console.log(response.data);
                    this.artistOptions = response.data;
                });
        },
        confirmArtist() {
            axios
                .post("/confirm-artist", {
                    artist: this.artistSelected,
                    gameId: this.game.id,
                })
                .then((response) => {
                    console.log(response.data);
                    this.artistOptions = response.data;
                });
        },
        submitSong() {
            //console.log(this.artistSelected);
            axios
                .post("/submit-song", {
                    song: this.song,
                    gameId: this.game.id,
                })
                .then((response) => {
                    console.log(response.data);
                    //this.artistOptions = response.data;
                });
        },
    },
};
</script>
