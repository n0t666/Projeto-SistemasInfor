package my.ipleiria.playxchange.fragments;

import android.content.Context;
import android.content.SharedPreferences;
import android.os.Bundle;

import androidx.fragment.app.Fragment;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ListView;
import android.widget.Toast;

import com.android.volley.Response;

import my.ipleiria.playxchange.R;
import my.ipleiria.playxchange.adapters.CarrinhoAdapter;
import my.ipleiria.playxchange.models.Carrinho;
import my.ipleiria.playxchange.models.SingletonLoja;
import my.ipleiria.playxchange.utils.Constants;


public class CarrinhoFragment extends Fragment {
    private Carrinho carrinho;
    private ListView lvLinhas;




    public CarrinhoFragment() {

    }

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
       View view = inflater.inflate(R.layout.fragment_carrinho, container, false);

        lvLinhas = view.findViewById(R.id.lvLinhas);

        SharedPreferences sharedPreferences = getContext().getSharedPreferences(Constants.CURRENT_USER, Context.MODE_PRIVATE);
        String token = sharedPreferences.getString(Constants.TOKEN, null);

        SingletonLoja.getInstance(getContext()).getCarrinhoAPI(getContext(),token, new Response.Listener<Carrinho>() {
            @Override
            public void onResponse(Carrinho response) {
                if (response == null || response.getLinhas() == null) {
                    Toast.makeText(getContext(), "Carrinho vazio", Toast.LENGTH_SHORT).show();
                    return;
                }
                carrinho = response;
                if(carrinho.getLinhas() == null || carrinho.getLinhas().isEmpty()){
                    Toast.makeText(getContext(), "Carrinho vazio", Toast.LENGTH_SHORT).show();
                }else{
                    lvLinhas.setAdapter(new CarrinhoAdapter(getContext(),carrinho.getLinhas()));
                }
            }
        });



       return view;
    }



}