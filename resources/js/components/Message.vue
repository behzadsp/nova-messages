<template>
    <div class="messager__message py-4 border-t border-40">
        <div class="font-light text-80 text-sm">
            <template v-if="hasMessager">
                <a class="link-default" :href="messagerUrl" v-text="messager"></a>

                said
            </template>

            <template v-else>
                Written
            </template>

            {{ date }}
        </div>

        <div class="mt-2" v-html="messageString"></div>
    </div>
</template>

<script>

    export default {
        props: {
            message: {
                type: Object,
                required: true
            }
        },

        computed: {
            messageString() {
                return _.find(this.message.fields, { attribute: 'message' }).value;
            },

            messager() {
                return _.find(this.message.fields, { attribute: 'messager' }).value;
            },

            messagerUrl() {
                let messagerId = _.find(this.message.fields, { attribute: 'messager' }).belongsToId;

                return `${Nova.config("base")}/resources/users/${messagerId}`;
            },

            date() {
                let now = moment();
                let date = moment.utc(_.find(this.message.fields, { attribute: 'created_at' }).value)
                    .tz(moment.tz.guess());

                if (date.isSame(now, 'minute')) {
                    return 'just now';
                }

                if (date.isSame(now, 'day')) {
                    return `at ${date.format('LT')}`;
                }

                if (date.isSame(now, 'year')) {
                    return `on ${date.format('MMM D')}`;
                }

                return `on ${date.format('ll')}`;
            },

            hasMessager() {
                return Boolean(this.messager);
            }
        }
    }
</script>
