<template>
  <BRow>
    <BCol cols="12">
      <BTableSimple borderless hover>
        <BThead class="border-bottom pb-3">
          <BTr>
            <BTh>{{ $t('adminPanel.id') }}</BTh>
            <BTh>{{ $t('adminPanel.theme') }}</BTh>
            <BTh class="text-md-left">
              <BButton
                size="sm"
                variant="white"
                @click="selectOrderType('createdAt')"
                class="font-weight-normal pointer-event shadow-none p-0 m-0"
              >
                {{ $t('adminPanel.createdAt') }}
                <span class="ml-1">
                  <FontAwesomeIcon :icon="['fas', selectCreatedDateSortIcon]" />
                </span>
              </BButton>
            </BTh>
            <BTh class="text-md-left">
              <BButton
                size="sm"
                variant="white"
                @click="selectOrderType('updatedAt')"
                class="font-weight-normal pointer-event shadow-none p-0 m-0"
              >
                {{ $t('adminPanel.lastModifiedDate') }}
                <span class="ml-1">
                  <FontAwesomeIcon :icon="['fas', selectUpdatedDateSortIcon]" />
                </span>
              </BButton>
            </BTh>
            <BTh class="text-md-left">
              <BButton
                size="sm"
                variant="white"
                @click="selectOrderType('status')"
                class="font-weight-normal pointer-event shadow-none p-0 m-0"
              >
                {{ $t('adminPanel.status') }}
                <span class="ml-1">
                  <FontAwesomeIcon :icon="['fas', selectStatusSortIcon]" />
                </span>
              </BButton>
            </BTh>
          </BTr>
        </BThead>
        <BTbody>
          <SupportAdminPanelRow
            v-for="support in supports"
            :key="support.id"
            :support="support"
          />
        </BTbody>
      </BTableSimple>
    </BCol>
  </BRow>
</template>

<script>
import SupportAdminPanelRow from './SupportAdminPanelRow';

export default {
  name: 'SupportAdminPanelTable',
  components: {
    SupportAdminPanelRow
  },
  data() {
    return {
      orderType: '',
      orderDirection: ''
    };
  },
  props: {
    supports: Array
  },
  computed: {
    selectCreatedDateSortIcon() {
      if (this.orderType === 'createdAt') {
        return this.orderDirection === 'DESC' ? 'caret-up' : 'caret-down';
      }
      return 'sort';
    },
    selectUpdatedDateSortIcon() {
      if (this.orderType === 'updatedAt') {
        return this.orderDirection === 'DESC' ? 'caret-up' : 'caret-down';
      }
      return 'sort';
    },
    selectStatusSortIcon() {
      if (this.orderType === 'status') {
        return this.orderDirection === 'DESC' ? 'caret-up' : 'caret-down';
      }
      return 'sort';
    }
  },
  methods: {
    selectOrderType(orderType) {
      this.orderDirection = this.orderDirection === 'DESC' ? 'ASC' : 'DESC';
      this.orderType = orderType;
      let orderTypeObject = {
        orderName: this.orderType,
        orderDirection: this.orderDirection
      };
      return this.$emit('orderType', orderTypeObject);
    }
  }
};
</script>

<style scoped></style>
