<!-- resources/js/components/SupportAgentChat.vue -->
<template>
    <div>
        <div v-for="message in messages" :key="message.id">
            <strong>{{ message.sender }}:</strong> {{ message.text }}
        </div>

        <div>
            <h4>User List:</h4>
            <ul>
                <li v-for="user in userList" :key="user.id">{{ user.name }}</li>
            </ul>
        </div>

        <input v-model="newMessage" @keyup.enter="sendMessage" placeholder="Type your message..." />
    </div>
</template>

<script>
export default {
    data() {
        return {
            messages: [],
            userList: [], // Assuming you have a list of users for support agents
            newMessage: '',
        };
    },
    mounted() {
        // Fetch initial messages and user list from the server
        this.fetchMessages();
        this.fetchUserList();
    },
    methods: {
        fetchMessages() {
            // Assuming you have an API endpoint to get messages
            axios.get('/api/messages')
                .then(response => {
                    this.messages = response.data;
                })
                .catch(error => {
                    console.error('Error fetching messages:', error);
                });
        },
        fetchUserList() {
            // Assuming you have an API endpoint to get the user list
            axios.get('/api/users')
                .then(response => {
                    this.userList = response.data;
                })
                .catch(error => {
                    console.error('Error fetching user list:', error);
                });
        },
        sendMessage() {
            // Assuming you have an API endpoint to send messages
            axios.post('/api/messages', {
                sender: 'support_agent',
                text: this.newMessage,
            })
            .then(response => {
                // Update messages array with the new message from the server response
                this.messages.push(response.data);
                // Clear the input field
                this.newMessage = '';
            })
            .catch(error => {
                console.error('Error sending message:', error);
            });
        },
    },
    
};

// Import Echo and configure it
import Echo from 'laravel-echo';

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    encrypted: true,
});

// In your Vue component

</script>
