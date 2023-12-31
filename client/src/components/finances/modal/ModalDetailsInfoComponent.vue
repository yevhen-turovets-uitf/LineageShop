<template>
  <BModal :id="`finance-details${financeOperation.id}`" hide-header hide-footer>
    <BContainer>
      <h2 class="font-weight-bold">
        {{ $t('finances.operationInformation') }}
      </h2>
      <BRow class="pt-3">
        <BCol md="4" class="font-weight-bold text-secondary">
          {{ $t('finances.dateOfOperation') }}
        </BCol>
        <BCol md="8">
          {{ financeOperation.createdAt | moment('Y.M.D HH:mm') }}
          <span class="text-secondary">
            ({{ financeOperation.createdAt | moment('from') }})
          </span>
        </BCol>
      </BRow>
      <BRow class="pt-3">
        <BCol md="4" class="font-weight-bold text-secondary">
          {{ $t('finances.description') }}
        </BCol>
        <BCol md="8">
          <span>{{ financeOperation.type.title }}</span>
          {{ $t('finances.money') }} #{{ financeOperation.id }}
          <div>
            <span class="text-secondary ml-2">
              {{ financeOperation.wallet.info }}
            </span>
            <FontAwesomeIcon
              :icon="['fas', 'credit-card']"
              size="1x"
              class="ml-1"
            />
          </div>
        </BCol>
      </BRow>
      <BRow class="pt-3" v-if="financeOperation.wallet.id">
        <BCol md="4" class="font-weight-bold text-secondary">
          {{ $t('finances.paymentMethod') }}
        </BCol>
        <BCol md="8">
          <span>{{ financeOperation.wallet.walletType.name }}</span>
        </BCol>
      </BRow>
      <BRow class="pt-3">
        <BCol md="4" class="font-weight-bold text-secondary">
          {{ $t('finances.sum') }}
        </BCol>
        <BCol md="8">
          <span v-if="!financeOperation.type.isEnrollment">-</span>
          {{ financeOperation.money }} $
        </BCol>
      </BRow>
      <BRow class="pt-3">
        <BCol md="4" class="font-weight-bold text-secondary">
          {{ $t('finances.operationStatus') }}
        </BCol>
        <BCol md="8">
          <p>
            <span :class="`text-${financeOperation.status.variant}`">{{
              financeOperation.status.title
            }}</span>
          </p>
        </BCol>
      </BRow>
      <BRow class="pt-3">
        <BCol md="4" class="font-weight-bold text-secondary">
          {{ $t('finances.outputNumber') }}
        </BCol>
        <BCol md="8"> #{{ financeOperation.id }} </BCol>
      </BRow>
      <BRow class="pt-3">
        <BCol md="4" class="font-weight-bold text-secondary">
          <span v-if="!financeOperation.type.isEnrollment">{{
            $t('finances.recipient')
          }}</span>
          <span v-else>{{ $t('finances.sender') }}</span>
        </BCol>
        <BCol md="8">
          {{ financeOperation.wallet.info }}
        </BCol>
      </BRow>
      <BRow class="pt-3">
        <BCol md="4" class="font-weight-bold text-secondary">
          <span v-if="!financeOperation.type.isEnrollment">{{
            $t('finances.toTheRecipient')
          }}</span>
          <span v-else>{{ $t('finances.fromTheSender') }}</span>
        </BCol>
        <BCol md="8">
          <span v-if="financeOperation.type.isEnrollment">-</span>
          {{ getTransferWithCommission }}
          <span v-if="financeOperation.wallet.walletType">
            {{ financeOperation.wallet.walletType.walletSymbol }}
          </span>
        </BCol>
      </BRow>
      <BRow class="font-weight-bold text-secondary pt-3" v-if="clickedCancel">
        <BCol md="8">
          {{ $t('finances.reasonForCancellation') }}
          <span class="text-danger"> *</span>
        </BCol>
      </BRow>
      <BRow class="font-weight-bold text-secondary pt-3" v-if="clickedCancel">
        <BCol md="12">
          <BFormTextarea
            :placeholder="$t('finances.reasonForCancellation')"
            v-model="cancelInfo"
          />
        </BCol>
      </BRow>
      <BRow class="pt-3">
        <BCol md="5">
          <BButton
            v-if="isNeedButtonCanceled && !clickedCancel"
            class="font-weight-bold"
            variant="danger"
            @click="clickedCancel = true"
          >
            {{ $t('finances.cancelWithdrawal') }}
          </BButton>
        </BCol>
      </BRow>
      <BRow class="pt-3" v-if="clickedCancel">
        <BCol md="7">
          <BButton
            v-if="isNeedButtonCanceled"
            class="font-weight-bold"
            variant="danger"
            @click="onChangeStatusFinanceOperation"
          >
            {{ $t('finances.confirmCancellation') }}
          </BButton>
        </BCol>
      </BRow>
    </BContainer>
  </BModal>
</template>

<script>
import { mapActions } from 'vuex';
import * as financeOperationsActions from '@/store/modules/finance-operation/types/actions';
import * as notificationActions from '@/store/modules/notification/types/actions';

export default {
  name: 'ModalDetailsInfoComponent',
  data() {
    return {
      transferWithCommission: null,
      commissionPercentage: this.$getConst('COMMISSION_PERCENT'),
      status: this.$getConst('FINANCE_OPERATION_STATUS').EXECUTED,
      clickedCancel: false,
      cancelInfo: ''
    };
  },
  props: {
    financeOperation: {
      id: Number,
      money: String,
      status: {
        title: String,
        variant: String,
        value: Number,
        isExecuted: Boolean,
        isCanceled: Boolean
      },
      createdAt: String,
      wallet: {
        id: Number,
        info: String,
        walletType: {
          id: Number,
          name: String,
          walletSymbol: String
        }
      }
    }
  },
  computed: {
    getTransferWithCommission() {
      if (
        this.financeOperation.type.value ===
        this.$getConst('FINANCE_OPERATION_TYPE').WRITE_OFFS
      ) {
        return (
          (this.financeOperation.money / 100) *
          (100 - this.commissionPercentage)
        ).toFixed(2);
      }
      return (
        (this.financeOperation.money / 100) *
        (100 + this.commissionPercentage)
      ).toFixed(2);
    },
    isNeedButtonCanceled() {
      return !(
        this.financeOperation.status.isExecuted ||
        this.financeOperation.status.isCanceled
      );
    }
  },
  methods: {
    closeModal() {
      this.$bvModal.hide(`finance-details${this.financeOperation.id}`);
    },
    ...mapActions('FinanceOperation', {
      changeStatusFinanceOperation:
        financeOperationsActions.CHANGE_STATUS_FINANCE_OPERATION_TO_CANCEL
    }),
    ...mapActions('notification', {
      setErrorNotification: notificationActions.SET_ERROR_NOTIFICATION
    }),
    async onChangeStatusFinanceOperation() {
      try {
        await this.changeStatusFinanceOperation(this.financeOperation.id);
        await this.closeModal();
      } catch (error) {
        this.setErrorNotification(error);
      }
    }
  }
};
</script>

<style scoped></style>
