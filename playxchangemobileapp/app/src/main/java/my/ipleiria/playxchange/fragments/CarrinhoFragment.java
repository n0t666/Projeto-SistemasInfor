package my.ipleiria.playxchange.fragments;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;

import androidx.constraintlayout.widget.ConstraintLayout;
import androidx.fragment.app.Fragment;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import com.google.android.material.button.MaterialButton;
import com.google.android.material.textfield.TextInputEditText;

import my.ipleiria.playxchange.R;
import my.ipleiria.playxchange.adapters.CarrinhoAdapter;
import my.ipleiria.playxchange.listeners.CarrinhoListener;
import my.ipleiria.playxchange.listeners.CodigoPromocionalListener;
import my.ipleiria.playxchange.models.Carrinho;
import my.ipleiria.playxchange.models.CodigoPromocional;
import my.ipleiria.playxchange.models.SingletonLoja;
import my.ipleiria.playxchange.CheckoutActivity;
import my.ipleiria.playxchange.utils.Constants;


public class CarrinhoFragment extends Fragment implements CarrinhoListener, CodigoPromocionalListener {
    private Carrinho carrinhoAux;
    private ListView lvLinhas;
    private TextView tvTotal, tvSubtotal, tvDesconto;
    private MaterialButton btnCheckout,btnApply;
    private TextInputEditText tfCodigoText;
    private View view;
    private ConstraintLayout clContent, clCarrinhoVazio;

    private CodigoPromocional codigo;




    public CarrinhoFragment() {

    }

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        view = inflater.inflate(R.layout.fragment_carrinho, container, false);
        lvLinhas = view.findViewById(R.id.lvLinhas);
        btnCheckout = view.findViewById(R.id.btnComp);
        tvTotal = view.findViewById(R.id.tvTotalText);
        tvSubtotal = view.findViewById(R.id.tvSubtotalTexto);
        tvDesconto = view.findViewById(R.id.tvDescontoTexto);
        btnApply = view.findViewById(R.id.btnApply);
        tfCodigoText = view.findViewById(R.id.tfCodigoText);
        clContent = view.findViewById(R.id.clContent);
        clCarrinhoVazio = view.findViewById(R.id.clCarrinhoVazio);
        return view;
    }


    @Override
    public void onRefreshCarrinho(Carrinho carrinho) {
        carrinhoAux = carrinho;
        if (carrinhoAux == null || carrinhoAux.getLinhas() == null) {
            Toast.makeText(getContext(), "Carrinho vazio", Toast.LENGTH_SHORT).show();
            btnApply.setEnabled(false);
            btnCheckout.setEnabled(false);
            tfCodigoText.setEnabled(false);
            clContent.setVisibility(View.GONE);
            clCarrinhoVazio.setVisibility(View.VISIBLE);
        } else {
            getActivity().setTitle("Carrinho" + " (" + carrinhoAux.getQuantidadeTotal()+ ")");
            setComponents();
            btnApply.setEnabled(true);
            btnCheckout.setEnabled(true);
            tfCodigoText.setEnabled(true);
            clContent.setVisibility(View.VISIBLE);
            clCarrinhoVazio.setVisibility(View.GONE);
        }
    }

    @Override
    public void onLinhaCarrinhoChanged() {
        recalculateTotal();
    }


    @Override
    public void onDescontoApplied() {

    }

    public void onButtonApplyClick(View view)
    {
        if (carrinhoAux != null && carrinhoAux.getLinhas() != null && !carrinhoAux.getLinhas().isEmpty())
        {
            String txtButton = btnApply.getText().toString();
            if(txtButton.equals(getResources().getString(R.string.txt_apply))){
                if(!tfCodigoText.getText().toString().isEmpty()){
                    String codigo = tfCodigoText.getText().toString();
                    if(codigo.isEmpty()){
                        Toast.makeText(getContext(), "Necessita de inserir um código promocional válido", Toast.LENGTH_SHORT).show();
                        return;
                    }
                    SharedPreferences sharedPreferences = getContext().getSharedPreferences(Constants.CURRENT_USER, Context.MODE_PRIVATE);
                    String token = sharedPreferences.getString(Constants.TOKEN,"");
                    if(!token.isEmpty()){
                        SingletonLoja.getInstance(getContext()).setCodigoPromocionalListener(this);
                        SingletonLoja.getInstance(getContext()).applyDescontoAPI(getContext(),token,codigo);
                    }else{
                        return;
                    }
                }
            }else if (txtButton.equals(getResources().getString(R.string.txt_remove_coupoun))){
                btnApply.setText(R.string.txt_apply);
                tfCodigoText.setText("");
                tfCodigoText.setEnabled(true);
                btnApply.setBackgroundColor(getResources().getColor(R.color.primary));
                tvTotal.setText(String.format("€%.2f", carrinhoAux.getTotal()));
                tvDesconto.setText(String.format("€%.2f", 0.00));
                tvSubtotal.setText(String.format("€%.2f", carrinhoAux.getTotal()));
            }
        }else{
            Toast.makeText(getContext(), "Carrinho vazio", Toast.LENGTH_SHORT).show();
        }
    }

    public void setComponents() {
        btnApply.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                onButtonApplyClick(v);
            }
        });
        btnCheckout.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                onCheckoutClick(v);
            }
        });
        tfCodigoText = view.findViewById(R.id.tfCodigoText);
        lvLinhas.setAdapter(new CarrinhoAdapter(getContext(), carrinhoAux.getLinhas(), this));
        tvTotal.setText(String.format("€%.2f", carrinhoAux.getTotal()));
        tvSubtotal.setText(String.format("€%.2f", carrinhoAux.getTotal()));

    }

    @Override
    public void onRefreshCodigo(CodigoPromocional codigoPromocional) {
        if(codigoPromocional!=null){
            codigo = codigoPromocional;
            if(codigoPromocional.getStatus() == 0){
                Toast.makeText(getContext(), "O código promocional já foi usado", Toast.LENGTH_SHORT).show();
                return;
            }else if (codigoPromocional.getStatus() == 1){
                tvDesconto.setText(String.format("€%.2f", codigoPromocional.getValorDescontado()));
                if(tvSubtotal!= null && carrinhoAux!=null){
                    tvSubtotal.setText(String.format("€%.2f", carrinhoAux.getTotal()));
                }

                if(tvSubtotal!=null&& carrinhoAux!=null){
                    Double total = carrinhoAux.getTotal() - codigoPromocional.getValorDescontado();
                    if(total < 0){
                        tvTotal.setText(String.format("€%.2f", 0.00));
                    }else{
                        tvTotal.setText(String.format("€%.2f", total));
                    }
                }

                if(btnApply!= null){
                    btnApply.setText(R.string.txt_remove_coupoun);
                    btnApply.setBackgroundColor(getResources().getColor(R.color.error));
                    tfCodigoText.setEnabled(false);
                }
            }
        }
    }

    private void recalculateTotal()
    {
        if (carrinhoAux != null) {
            double total = 0;

            for(int i=0;i < carrinhoAux.getLinhas().size();i++){
                total += (carrinhoAux.getLinhas().get(i).getPreco()) * (carrinhoAux.getLinhas().get(i).getQuantidade() );
            }
            carrinhoAux.setTotal(total);

            if (tvSubtotal != null) {
                tvSubtotal.setText(String.format("€%.2f", total));
            }


            if(codigo!=null && codigo.getStatus()!= 0){
                double valorDescontado = (total * codigo.getValorDescontado()) / 100;
                double totalComDesconto = total - valorDescontado;

                if(totalComDesconto < 0 ){
                    totalComDesconto = 0;
                }

                if(tvDesconto != null){
                    tvDesconto.setText(String.format("€%.2f", valorDescontado));
                }

                tvTotal.setText(String.format("€%.2f", totalComDesconto));
            }else {
                tvTotal.setText(String.format("€%.2f", total));
            }
        }
    }

    private void onCheckoutClick(View view)
    {
        int codigoId = -1;

        if(codigo != null && codigo.getId() > 0){
            codigoId = codigo.getId();
        }

        if(carrinhoAux != null && carrinhoAux.getLinhas() != null && !carrinhoAux.getLinhas().isEmpty()){
            Intent intent = new Intent(getContext(), CheckoutActivity.class);
            if(codigoId != -1) {
                intent.putExtra("CODIGO_ID", codigoId);
            }
            startActivity(intent);
        }else{
            Toast.makeText(getContext(), "Carrinho vazio", Toast.LENGTH_SHORT).show();
        }
    }

    @Override
    public void onResume() {
        super.onResume();
        SharedPreferences sharedPreferences = getContext().getSharedPreferences(Constants.CURRENT_USER, Context.MODE_PRIVATE);
        String token = sharedPreferences.getString(Constants.TOKEN, null);
        SingletonLoja.getInstance(getContext()).setCarrinhoListener(this);
        SingletonLoja.getInstance(getContext()).getCarrinhoAPI(getContext(), token);
    }
}