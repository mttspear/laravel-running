<template>
    <div>
        <div v-if="isGameActive == false" class="row justify-content-center">
            <div class="col-md-6">
                <h3>
                    <img class="icon_img" src="/img/community.png" />
                    Past Games
                </h3>
                <user-games-component
                    :games="this.dataInactiveGames"
                ></user-games-component>
            </div>
            <div class="col-md-6">
                <h3>
                    <img class="icon_img" src="/img/community.png" />
                    Available Players
                </h3>
                <available-players-component
                    :auth-user="this.dataAuthUser"
                    :current-users="this.dataCurrentUsers"
                ></available-players-component>
            </div>
        </div>
        <div v-if="isGameActive" class="row justify-content-center">
            <div class="col-md-8 text-center">
                <h3>Current Game</h3>
            </div>
            <div class="col-md-8">
                <div class="container">
                    <div class="row justify-content-center">
                        <div v-if="this.dataArtistInfo != null">
                            <div class="row justify-content-center text-center">
                                <img
                                    class="artist-image"
                                    v-bind:src="
                                        this.dataArtistInfo.images[0]
                                            .resource_url
                                    "
                                />
                            </div>
                            <div
                                class="
                                    artist-title
                                    row
                                    justify-content-center
                                    text-center
                                    mt-3
                                "
                            >
                                <b-alert show>
                                    Name a Song By
                                    {{ this.dataArtistInfo.name }}
                                </b-alert>
                            </div>
                        </div>

                        <scoreboard-component
                            :score="this.dataGameScore"
                            :playerTurn="this.currentUserMove.playerId"
                            :score-limit="this.dataActiveGame.scoreLimit"
                        >
                        </scoreboard-component>

                        <flip-countdown
                            class="mt-3"
                            :deadline="currentUserMove.expired + ' utc'"
                            :showDays="false"
                            :showHours="false"
                            :showMinutes="true"
                        ></flip-countdown>

                        <div class="col-md-6 mt-3">
                            <loading-progress
                                v-if="renderLoad"
                                :progress="progress"
                                :indeterminate="indeterminate"
                                :counter-clockwise="counterClockwise"
                                :hide-background="hideBackground"
                                size="64"
                                rotate
                                fillDuration="2"
                                rotationDuration="1"
                            />

                            <b-form
                                inline
                                v-if="renderPickArtist"
                                @submit.prevent
                            >
                                <b-form-group
                                    id="input-group-artist"
                                    label="Artist:"
                                    label-for="input-artist"
                                >
                                    <b-form-input
                                        id="input-artist"
                                        v-model="artistEntered"
                                        type="text"
                                        placeholder="Artist Name"
                                        required
                                    ></b-form-input>
                                </b-form-group>
                                <b-button
                                    @click="submitArtist()"
                                    variant="primary"
                                    >Submit</b-button
                                >
                            </b-form>

                            <b-form
                                class="text-center"
                                v-if="renderArtistOptions"
                                @submit.prevent
                            >
                                <b-form-group
                                    label="Confirm Artist"
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
                                <b-button
                                    @click="confirmArtist()"
                                    variant="primary"
                                    >Confirm Artist</b-button
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
                                <b-button
                                    @click="submitSong()"
                                    variant="primary"
                                    >Submit</b-button
                                >
                            </b-form>
                            <b-alert
                                show
                                variant="info"
                                v-if="
                                    currentUserMove.playerId != dataAuthUser.id
                                "
                            >
                                Other Players Turn
                            </b-alert>
                        </div>
                        <div class="col-md-6 mt-3">
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
            </div>
        </div>
    </div>
</template>

<script>
import FlipCountdown from "vue2-flip-countdown";

export default {
    components: { FlipCountdown },
    props: [
        "propActiveGame",
        "propGameScores",
        "propGameScore",
        "propAuthUser",
        "propArtistInfo",
        "propInactiveGames",
        "propCurrentUsers",
    ],
    computed: {
        pickArtist() {
            if (this.isEmpty(this.dataActiveGame)) {
                return null;
            }
            if (
                this.currentUserMove.playerId === this.dataAuthUser.id &&
                this.currentUserMove.answerStatus === "pick-artist"
            ) {
                return true;
            } else {
                return false;
            }
        },
        renderPickArtist() {
            if (this.isEmpty(this.dataActiveGame)) {
                return null;
            }
            if (
                this.currentUserMove.playerId === this.dataAuthUser.id &&
                this.currentUserMove.answerStatus === "pick-artist"
            ) {
                return true;
            } else {
                return false;
            }
        },
        renderArtistOptions() {
            if (
                this.artistOptions === null
                //this.currentUserMove.playerId == this.user.id
            ) {
                return false;
            } else {
                return true;
            }
        },
        renderPickSong() {
            if (this.isEmpty(this.dataActiveGame)) {
                return null;
            }
            if (this.renderPickArtist) {
                return false;
            } else if (this.currentUserMove.playerId === this.dataAuthUser.id) {
                return true;
            } else {
                return false;
            }
        },

        currentUserMove() {
            if (this.isEmpty(this.dataActiveGame)) {
                return null;
            }
            let playerTurn = this.dataGameScores.filter(function (item) {
                return item.answerStatus === "player-turn";
            });
            let pickArtist = this.dataGameScores.filter(function (item) {
                return item.answerStatus === "pick-artist";
            });
            if (playerTurn.length !== 0) {
                return playerTurn[0];
            } else {
                return pickArtist[0];
            }
        },
        currentGameScores() {
            if (this.isEmpty(this.dataActiveGame)) {
                return null;
            }
            let latest = this.dataGameScores.filter(function (item) {
                return item.playerAnswer != null;
            });
            return latest;
        },
        isGameActive() {
            if (this.isEmpty(this.dataActiveGame)) {
                return false;
            } else {
                return true;
            }
        },
    },
    mounted() {
        Echo.private("game." + this.dataAuthUser.id).listen(
            "GameEvent",
            (response) => {
                this.updateFromResponse(response);
            }
        );
    },
    data() {
        return {
            scoreFields: [
                "artistName",
                "playerAnswer",
                "answerStatus",
                "playerName",
            ],
            dataActiveGame: JSON.parse(this.propActiveGame),
            dataGameScores: JSON.parse(this.propGameScores),
            dataGameScore: JSON.parse(this.propGameScore),
            dataInactiveGames: this.propInactiveGames,
            dataCurrentUsers: this.propCurrentUsers,
            dataArtistInfo: this.propArtistInfo,
            dataAuthUser: this.propAuthUser,
            artist: null,
            artistEntered: null,
            artistSelected: null,
            artistOptions: null,
            song: null,
            progress: 0,
            indeterminate: true,
            counterClockwise: false,
            hideBackground: false,
            renderLoad: false,
        };
    },
    methods: {
        submitArtist() {
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
                    gameId: this.dataActiveGame.id,
                })
                .then((response) => {
                    this.artistOptions = null;
                    this.artistEntered = null;
                    this.updateFromResponse(response);
                });
        },
        submitSong() {
            this.renderLoad = true;
            axios
                .post("/submit-song", {
                    song: this.song,
                    gameId: this.dataActiveGame.id,
                })
                .then((response) => {
                    this.song = null;
                    this.updateFromResponse(response);
                });
        },
        updateFromResponse(response) {
            console.log("response");
            console.log(response);
            this.dataGameScores = JSON.parse(response.data.gameScores);
            this.dataGameScore = JSON.parse(response.data.gameScore);
            if (
                typeof response.data.artist !== "undefined" &&
                response.data.artist != null
            ) {
                this.dataArtistInfo = response.data.artist;
            }

            if (
                typeof response.data.activeGame !== "undefined" &&
                response.data.activeGame != null
            ) {
                this.dataActiveGame = JSON.parse(response.data.activeGame);
            }
            this.renderLoad = false;
        },
        isEmpty(obj) {
            return Object.keys(obj).length === 0;
        },
    },
};
</script>
