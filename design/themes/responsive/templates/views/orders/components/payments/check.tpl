<div class="ty-control-group">
    <label for="customer_signature" class="ty-control-group__title cm-required">{__("customer_signature")}</label>
    <input id="customer_signature" size="35" type="text" name="payment_info[customer_signature]" value="{$cart.payment_info.customer_signature}" class="ty-input-text cm-autocomplete-off cm-focus" />
</div>
<div class="ty-control-group">
    <label for="checking_account_number" class="ty-control-group__title cm-required">{__("checking_account_number")}</label>
    <input id="checking_account_number" size="35" type="text" name="payment_info[checking_account_number]" value="{$cart.payment_info.checking_account_number}" class="ty-input-text cm-autocomplete-off" />
</div>
<div class="ty-control-group">
    <label for="bank_routing_number" class="ty-control-group__title cm-required">{__("bank_routing_number")}</label>
    <input id="bank_routing_number" size="35" type="text" name="payment_info[bank_routing_number]" value="{$cart.payment_info.bank_routing_number}" class="ty-input-text cm-autocomplete-off" />
</div>