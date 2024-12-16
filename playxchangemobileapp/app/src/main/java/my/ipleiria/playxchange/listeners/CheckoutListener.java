package my.ipleiria.playxchange.listeners;

import my.ipleiria.playxchange.models.Checkout;

public interface CheckoutListener {
    void onRefreshCheckout(Checkout checkout);
    void onCheckoutSucess();
}
