<template>
  <BRow>
    <BCol cols="12">
      <BTableSimple borderless hover>
        <BThead class="border-bottom pb-3">
          <BTr>
            <BTh>{{ $t('adminPanel.id') }}ID</BTh>
            <BTh>{{ $t('adminPanel.buyer') }}Покупатель</BTh>
            <BTh>{{ $t('adminPanel.seller') }}Продавец</BTh>
            <BTh>{{ $t('adminPanel.orderStatus') }}Статус заказа</BTh>
            <BTh> </BTh>
          </BTr>
        </BThead>
        <BTbody>
          <OrderAdminPanelRow
            v-for="order in orders"
            :key="order.id"
            :order="order"
          ></OrderAdminPanelRow>
        </BTbody>
      </BTableSimple>
    </BCol>
  </BRow>
</template>

<script>
import OrderAdminPanelRow from './OrderAdminPanelRow';

export default {
  name: 'OrderAdminPanelTable',
  components: {
    OrderAdminPanelRow
  },
  props: {
    orders: Object
  }
};
</script>

<style scoped></style>
