<template>
    <div v-if="isGameActive" class="container">
        <div class="row justify-content-center">
            <flip-countdown
                :deadline="currentUserMove.expired + ' utc'"
                :showDays="false"
                :showHours="false"
                :showMinutes="true"
            ></flip-countdown>
            <div class="col-md-12">
                <li v-for="item in this.score" :key="item.playerId">
                    Player: {{ item.playerId }} - {{ item.score }}
                </li>
                Player {{ currentUserMove.playerId }} Move
            </div>
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

                <b-form v-if="renderPickSong" @submit.prevent>
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
                <b-table
                    striped
                    hover
                    :fields="scoreFields"
                    :items="currentGameScores"
                >
                </b-table>
            </div>
        </div>
    </div>
</template>

<script>
import FlipCountdown from "vue2-flip-countdown";

export default {
    components: { FlipCountdown },
    props: ["activeGame", "gameScores", "gameScore", "authUser"],
    computed: {
        pickArtist() {
            if (this.isEmpty(this.activeGame)) {
                return null;
            }
            if (
                this.currentUserMove.playerId === this.user.id &&
                this.currentUserMove.answerStatus === "pick-artist"
            ) {
                return true;
            } else {
                return false;
            }
        },
        renderPickArtist() {
            if (this.isEmpty(this.activeGame)) {
                return null;
            }
            if (
                this.currentUserMove.playerId === this.user.id &&
                this.currentUserMove.answerStatus === "pick-artist"
            ) {
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
            if (this.isEmpty(this.activeGame)) {
                return null;
            }
            if (this.renderPickArtist) {
                return false;
            } else {
                return true;
            }
        },
        currentUserMove() {
            if (this.isEmpty(this.activeGame)) {
                return null;
            }
            let playerTurn = this.scores.filter(function (item) {
                return item.answerStatus === "player-turn";
            });
            let pickArtist = this.scores.filter(function (item) {
                return item.answerStatus === "pick-artist";
            });
            if (playerTurn.length !== 0) {
                return playerTurn[0];
            } else {
                return pickArtist[0];
            }
        },
        currentGameScores() {
            if (this.isEmpty(this.activeGame)) {
                return null;
            }
            let latest = this.scores.filter(function (item) {
                return item.playerAnswer != null;
            });
            return latest;
        },
        isGameActive() {
            if (this.isEmpty(this.activeGame)) {
                return false;
            } else {
                return true;
            }
        },
    },
    mounted() {
        Echo.private("game." + this.authUser.id).listen(
            "GameEvent",
            (response) => {
                console.log(response);
                this.updateFromResponse(response);
            }
        );

        Echo.channel("home").listen("NewMessage", (e) => {
            console.log(e);
        });
    },
    data() {
        return {
            scoreFields: ["artistName", "playerAnswer", "answerStatus"],
            game: JSON.parse(this.activeGame),
            scores: JSON.parse(this.gameScores),
            score: JSON.parse(this.gameScore),
            user: this.authUser,
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
                    this.updateFromResponse(response);
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
                    this.song = null;
                    this.updateFromResponse(response);
                });
        },
        updateFromResponse(response) {
            this.scores = JSON.parse(response.data.gameScores);
            console.log(JSON.parse(response.data.gameScore));
            this.score = JSON.parse(response.data.gameScore);
        },
        isEmpty(obj) {
            return Object.keys(obj).length === 0;
        },
    },
};
</script>
