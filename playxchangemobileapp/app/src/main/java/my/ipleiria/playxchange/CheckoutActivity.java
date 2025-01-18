package my.ipleiria.playxchange;

import static android.app.PendingIntent.getActivity;

import android.content.Context;
import android.content.Intent;
import android.graphics.drawable.Drawable;
import android.os.Bundle;
import android.view.View;
import android.widget.RadioButton;
import android.widget.RadioGroup;
import android.widget.Toast;

import androidx.activity.EdgeToEdge;
import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.content.res.AppCompatResources;
import androidx.appcompat.view.ContextThemeWrapper;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;

import com.bumptech.glide.Glide;
import com.bumptech.glide.load.engine.DiskCacheStrategy;
import com.bumptech.glide.request.target.SimpleTarget;
import com.bumptech.glide.request.transition.Transition;
import com.google.android.material.radiobutton.MaterialRadioButton;
import com.google.android.material.textview.MaterialTextView;

import java.util.ArrayList;

import my.ipleiria.playxchange.listeners.CheckoutListener;
import my.ipleiria.playxchange.models.Checkout;
import my.ipleiria.playxchange.models.SingletonLoja;
import my.ipleiria.playxchange.utils.Constants;

public class CheckoutActivity extends AppCompatActivity implements CheckoutListener {

    private RadioGroup rgMetodosPagamento, rgMetodosEnvio;
    private MaterialTextView tvTotalComDesconto, tvSubtotal, tvDesconto, tvEnvio, tvPagamento,tvTaxas,tvPagamentoError,tvEnvioError;
    private Checkout auxCheckout;
    private int codigoId = -1;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        EdgeToEdge.enable(this);
        setContentView(R.layout.activity_checkout);
        ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.main), (v, insets) -> {
            Insets systemBars = insets.getInsets(WindowInsetsCompat.Type.systemBars());
            v.setPadding(systemBars.left, systemBars.top, systemBars.right, systemBars.bottom);
            return insets;
        });

        rgMetodosPagamento = findViewById(R.id.rgPagamento);
        rgMetodosEnvio = findViewById(R.id.rgEnvio);
        tvSubtotal = findViewById(R.id.tvSub);
        tvTotalComDesconto = findViewById(R.id.tvTotalComDesconto);
        tvTaxas = findViewById(R.id.tvTaxas);
        tvDesconto = findViewById(R.id.tvDesconto);
        tvPagamentoError = findViewById(R.id.tvPagamentoError);
        tvEnvioError = findViewById(R.id.tvEnvioError);
        Bundle extras = getIntent().getExtras();
        if (extras != null) {
            codigoId = extras.getInt("CODIGO_ID");
        }

        this.setTitle("Checkout");
        if (getSupportActionBar() != null) {
            getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        }

        getCheckoutDetails();
    }

    private void getCheckoutDetails(){
        SingletonLoja.getInstance(getApplicationContext()).setCheckoutListener(this);
        String token = getSharedPreferences(Constants.CURRENT_USER, Context.MODE_PRIVATE).getString(Constants.TOKEN, null);
        SingletonLoja.getInstance(getApplicationContext()).checkoutAPI(getApplicationContext(), token,codigoId);

    }

    @Override
    public void onRefreshCheckout(Checkout checkout) {
        if(checkout != null){
            auxCheckout = checkout;
            tvSubtotal.append( " " + String.format("%.2f",checkout.getTotalSemDesconto()) + "€");
            tvTotalComDesconto.append(" " + String.format("%.2f",checkout.getTotal()) + "€");

            if(checkout.getValorDesconto() > 0){
                tvDesconto = findViewById(R.id.tvDesconto);
                tvDesconto.setVisibility(View.VISIBLE);
                tvDesconto.append(" " + String.format("%.2f",checkout.getValorDesconto()) + "€");
            }else{
                tvDesconto.setVisibility(View.GONE);
            }


            tvTaxas.setVisibility(View.GONE);

            setMetodosPagamento(checkout.getMetodosPagamento());
            setMetodosEnvio(checkout.getMetodosEnvio());
        }else{
            finish();
        }

    }

    @Override
    public void onCheckoutSucess() {
        Intent intent = new Intent(this, EncomendaSucesso.class);
        startActivity(intent);
    }

    private void setMetodosPagamento(ArrayList<Checkout.MetodoPagamento> metodosPagamento){
       if(rgMetodosPagamento!=null){
           rgMetodosPagamento.removeAllViews();
           for(Checkout.MetodoPagamento metodoPagamento : metodosPagamento){
                RadioButton rb = new RadioButton(new ContextThemeWrapper(this, R.style.PagamentosRadioButton));
                rb.setId(View.generateViewId());
                rb.setTag(metodoPagamento.getId());
                rb.setButtonDrawable(null);
                rb.setBackground(AppCompatResources.getDrawable(this,R.drawable.bg_radio_button));
                Glide.with(this)
                          .load(metodoPagamento.getLogo())
                          .override(64, 128)
                          .diskCacheStrategy(DiskCacheStrategy.ALL)
                          .into(new SimpleTarget<Drawable>() {
                            @Override
                            public void onResourceReady(@NonNull Drawable resource, @Nullable Transition<? super Drawable> transition) {
                                 rb.setCompoundDrawablesWithIntrinsicBounds(resource,null,null,null);
                            }
                          });
                rgMetodosPagamento.addView(rb);
           }

       }
    }

    private void setMetodosEnvio(ArrayList<Checkout.MetodoEnvio> metodosEnvio){
        if(rgMetodosEnvio!=null){
            rgMetodosEnvio.removeAllViews();
            for(Checkout.MetodoEnvio metodoEnvio : metodosEnvio){
                MaterialRadioButton rb = new MaterialRadioButton(this);
                rb.setId(View.generateViewId());
                rb.setTextAppearance(R.style.EnviosText);
                RadioGroup.LayoutParams layoutParams = new RadioGroup.LayoutParams(
                        RadioGroup.LayoutParams.WRAP_CONTENT,
                        RadioGroup.LayoutParams.WRAP_CONTENT
                );
                rb.setTag(metodoEnvio.getId());
                rb.setLayoutParams(layoutParams);
                rb.setText(metodoEnvio.getNome());
                rb.setId(View.generateViewId());
                rgMetodosEnvio.addView(rb);
            }
        }
    }
    public void onFinalizarCompra(View view){
        int selectedPagamento = rgMetodosPagamento.getCheckedRadioButtonId();
        int selectedEnvio = rgMetodosEnvio.getCheckedRadioButtonId();
        if(selectedPagamento == -1){
            Toast.makeText(this, R.string.txt_metodo_p,Toast.LENGTH_LONG).show();
            tvPagamentoError.setVisibility(View.VISIBLE);
            return;
        }

        if(selectedEnvio == -1){
            Toast.makeText(this, R.string.txt_metodo_e,Toast.LENGTH_LONG).show();
            tvEnvioError.setVisibility(View.VISIBLE);
            return;
        }

        tvPagamentoError.setVisibility(View.GONE);
        tvEnvioError.setVisibility(View.GONE);

        RadioButton rbPagamento = findViewById(selectedPagamento);
        int pagamentoId = (int) rbPagamento.getTag();

        MaterialRadioButton rbEnvio = findViewById(selectedEnvio);
        int envioId = (int) rbEnvio.getTag();

        Checkout.MetodoPagamento pagamento = auxCheckout.getMetodoPagamentoById(pagamentoId);
        Checkout.MetodoEnvio envio = auxCheckout.getMetodoEnvioById(envioId);

        if(pagamento==null){
            tvPagamentoError.setVisibility(View.VISIBLE);
            tvPagamentoError.setText(R.string.txt_pagamento_invalid);
            return;
        }

        if(envio==null){
            tvEnvioError.setVisibility(View.VISIBLE);
            tvEnvioError.setText(R.string.txt_envio_invalid);
            return;
        }

        String token = getSharedPreferences(Constants.CURRENT_USER, Context.MODE_PRIVATE).getString(Constants.TOKEN, null);
        SingletonLoja.getInstance(getApplicationContext()).addFaturaAPI(getApplicationContext(),token,pagamento.getId(),envio.getId(),codigoId);
    }

    @Override
    public boolean onSupportNavigateUp(){
        finish();
        return true;
    }

}