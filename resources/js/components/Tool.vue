<template>
    <div>
        <h4 class="text-90 font-normal text-2xl mb-3">
            Messages
        </h4>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow pt-2">
            <div class="flex border-40 remove-bottom-border px-8">
                <div class="w-full mt-6 pb-2">
                    <h4 class="font-normal text-80">
                        Write new message
                    </h4>

                    <textarea class="w-full form-control form-input form-input-bordered py-3 h-auto mt-2"
                    id="messageer"
                    dusk="messageer"
                    rows="5"
                    v-model="message"
                    @keydown.enter.meta="createMessage">
                    </textarea>
                </div>
            </div>

            <div class="flex justify-between px-8 pb-4 border-b border-40">
                <div class="help-text">
                    On MacOS, press ⌘ + Enter to send
                </div>

                <button class="flex-shrink-0 shadow rounded focus:outline-none focus:ring bg-primary-500 hover:bg-primary-400 active:bg-primary-600 text-white dark:text-gray-800 inline-flex items-center font-bold px-4 h-9 text-sm flex-shrink-0 mb-3 mt-4"
                    type="submit"
                    @click="createMessage">
                    Send Message
                </button>
            </div>

            <div class="flex border-b border-40 remove-bottom-border px-8" v-if="hasMessages">
                <div class="w-full py-6">
                    <h3 class="text-90 font-bold text-lg mb-4">Messages</h3>

                    <message :message="message" v-for="(message, key) in data.resources" :key="key"></message>
                </div>
            </div>

            <div class="bg-20 rounded-b" v-if="hasPagination">
                <nav class="flex justify-between items-center">
                    <button class="text-xs font-bold py-3 px-4 focus:outline-none rounded-bl-lg focus:ring focus:ring-inset"
                        :class="paginationClass(hasNextLink)"
                        :disabled="! hasNextLink"
                        @click="getMessages(data.next_page_url)">
                        Older
                    </button>

                    <button class="text-xs font-bold py-3 px-4 focus:outline-none rounded-bl-lg focus:ring focus:ring-inset"
                        :class="paginationClass(hasPrevLink)"
                        :disabled="! hasPrevLink"
                        @click="getMessages(data.prev_page_url)">
                        Newer
                    </button>
                </nav>
            </div>
        </div>
    </div>
</template>

<script>
    import Message from './Message';

    export default {
        props: ['resourceName', 'resourceId', 'field'],

        components: { Message },

        data() {
            return {
                baseMessageUri: '/nova-api/messages',
                message: '',
                data: {
                    next_page_url: '',
                    prev_page_url: '',
                    resources: {}
                }
            }
        },

        mounted() {
            this.getMessages(this.messagesUri);
        },

        computed: {
            messagesUri() {
                return `${this.baseMessageUri}?page=1`;
            },

            hasMessages() {
                return Boolean(this.data.resources.length);
            },

            hasNextLink() {
                return Boolean(this.data.next_page_url);
            },

            hasPrevLink() {
                return Boolean(this.data.prev_page_url);
            },

            hasPagination() {
                return this.hasNextLink || this.hasPrevLink;
            },

            queryParams() {
                return `&orderBy=created_at&orderByDirection=desc&viaResource=${this.resourceName}&viaResourceId=${this.resourceId}&viaRelationship=messages&relationshipType=hasMany`;
            }
        },

        methods: {
            createMessage() {
                if (! this.message) {
                    return false;
                }

                let payload = {
                    message: this.message,
                    viaResource: this.resourceName,
                    viaResourceId: this.resourceId,
                    viaRelationship: 'messages',
                };

                Nova.request().post(this.baseMessageUri, payload)
                    .then(() => {
                        this.getMessages(this.messagesUri);

                        this.resetMessage();

                        Nova.success(`A new message has been created.`);
                    })
                    .catch(response => Nova.error(response));
            },

            getMessages(uri) {
                Nova.request().get(`${uri}${this.queryParams}`)
                    .then(({ data }) => this.data = data);
            },

            paginationClass(isActive) {
                return isActive
                    ? 'text-primary-500 hover:text-primary-400 active:text-primary-600'
                    : 'text-gray-300 dark:text-gray-600';
            },

            resetMessage() {
                this.message = '';
            }
        }
    }
</script>
