<template>
  <div>
    <div class="text-uppercase text-secondary mb-3">
      {{ $t('supportChat.support') }}
    </div>
    <BContainer>
      <BRow>
        <BCol md="8">
          <SupportMessages :support-messages="supportMessages" />
        </BCol>
        <BCol md="4">
          <SupportRequestDetail :support="support" />
        </BCol>
      </BRow>

      <BRow>
        <BCol md="8" v-if="support.status.id !== 2">
          <BFormGroup>
            <label>{{ $t('supportChat.text') }}</label>
            <BFormTextarea
              v-model="messageText"
              class="shadow-none"
            ></BFormTextarea>
          </BFormGroup>
          <BButton
            @click="sendMessageRequestFront"
            variant="primary"
            class="shadow-none"
            >{{ $t('supportChat.send') }}
          </BButton>
          <BButton
            @click="setSupportRequestStatus(2)"
            variant="outline-danger"
            class="shadow-none ml-3"
          >
            {{ $t('supportChat.closeTicket') }}
          </BButton>
        </BCol>
        <BCol md="8" v-else>
          <BButton
            @click="setSupportRequestStatus(1)"
            variant="primary"
            class="shadow-none"
          >
            {{ $t('supportChat.openTicket') }}
          </BButton>
        </BCol>
      </BRow>
    </BContainer>
  </div>
</template>
<script>
import * as SupportGetters from '@/store/modules/support-request/types/getters';
import * as SupportActions from '@/store/modules/support-request/types/actions';
import { mapActions, mapGetters } from 'vuex';
import SupportRequestDetail from './SupportRequestDetail';
import SupportMessages from './SupportMessages';

export default {
  name: 'SupportChatComponent',
  components: { SupportMessages, SupportRequestDetail },
  data() {
    return {
      messageText: ''
    };
  },
  computed: {
    ...mapGetters('SupportRequest', {
      support: SupportGetters.GET_SUPPORT_REQUEST,
      supportMessages: SupportGetters.GET_SUPPORT_REQUEST_MESSAGES
    })
  },
  methods: {
    ...mapActions('SupportRequest', {
      sendSupportRequestMessage: SupportActions.SEND_SUPPORT_REQUEST_MESSAGE,
      getSupportRequest: SupportActions.GET_SUPPORT_REQUEST,
      getMessages: SupportActions.GET_SUPPORT_REQUEST_MESSAGES,
      setRequestStatus: SupportActions.SET_SUPPORT_REQUEST_STATUS
    }),
    async supportChatDetailsInitialize() {
      try {
        await this.getMessages(this.$route.params.id);
        await this.getSupportRequest(this.$route.params.id);
      } catch (error) {
        this.setErrorNotification(error);
      }
    },
    async sendMessageRequestFront() {
      try {
        await this.sendSupportRequestMessage({
          text: this.messageText,
          supportRequestId: this.support.id,
          supportRequestAuthorId: this.support.authorId,
          supportRequestSubjectId: this.support.subject.id
        });
        this.messageText = '';
      } catch (error) {
        this.setErrorNotification(error);
      }
    },
    setSupportRequestStatus(statusId) {
      try {
        let data = {
          requestId: this.support.id,
          requestStatusId: statusId
        };
        this.setRequestStatus(data);
      } catch (error) {
        this.setErrorNotification(error);
      }
    }
  },
  mounted() {
    this.supportChatDetailsInitialize();
  }
};
</script>
