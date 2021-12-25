<template>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">チャットルーム</div>
                <div class="card-body">
                    <div id="chat-scroll" class="chat bg-light p-4 overflow-auto" style="height:500px;">
                        <div id="scroll-child">
                            <div v-for="(message, key) in messages" :key="key">
                                <div v-if="chat_user_id === message.user_id">
                                    <div class="message d-flex flex-row-reverse align-items-start mb-4">
                                        <div class="message-icon rounded-circle bg-secondary text-white fs-3">
                                        <i class="fas fa-user"></i>
                                        </div>
                                        <div class="flex-fill">
                                            <div class="row">
                                                <div style="text-align: right;">
                                                    <p class="message-text p-2 me-2 mb-0 bg-info">{{ message.message }}</p>
                                                </div>
                                                <div class="row" style="padding-right: 7px;">
                                                    <div class="d-flex flex-row-reverse" style="padding-right: 0px;">
                                                        <p class="ml-1 text-secondary" style="font-size:10px; padding-left: 10px;">{{ message.created_at }}</p>
                                                        <p class="ml-1 text-secondary" style="font-size:10px; padding-left: 10px;">{{ message.user_name }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div v-if="chat_user_id !== message.user_id">
                                    <div class="message d-flex flex-row align-items-start">
                                        <div class="message-icon rounded-circle bg-secondary text-white fs-3">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div class="flex-fill">
                                            <div class="row">
                                                <div>
                                                    <p class="message-text p-2 ms-2 mb-0 bg-warning">{{ message.message }}</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="d-flex">
                                                    <p class="ml-1 text-secondary" style="font-size:10px; padding-left: 10px;">{{ message.user_name }}</p>
                                                    <p class="ml-1 text-secondary" style="font-size:10px; padding-left: 10px;">{{ message.created_at }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- <div style="height:50px"></div> -->
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="input-group input-group-lg">
                        <input type="text" class="form-control" v-model="text">
                        <div class="input-group-btn">
                            <button class="btn btn-default btn-lg btn-info message-send-button" @click="postMessage" :disabled="!textExists">送信</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>


export default {
    data() {
        return {
            text: "",
            messages: [],
            chat_user_id: "",
        };
    },
    computed: {
        textExists() {
            return this.text.length > 0;
        }
    },
    created() {
        this.fetchMessages();
        Echo.private("chat").listen(".chatroom", e => {
            this.messages.push({
                message: e.message.message,
                user_id: e.message.user_id,
                user_name: e.message.user_name,
                created_at: e.message.created_at,
            });
        });
    },
    updated() {
        let container = this.$el.querySelector("#chat-scroll");
        container.scrollTop = container.scrollHeight-100;
    },
    methods: {
        fetchMessages() {
            axios.get("/chatroom/messages").then(response => {
                this.messages = response.data.chat_data;
                this.chat_user_id = response.data.chat_user_id;
            });
        },
        postMessage(message) {
            axios.post("/chatroom/messages", { message: this.text }).then(response => {
                this.text ="";
            });
        }
    }
};
</script>