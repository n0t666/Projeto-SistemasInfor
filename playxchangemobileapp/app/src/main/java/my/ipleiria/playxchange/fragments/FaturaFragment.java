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

import java.util.ArrayList;

import my.ipleiria.playxchange.R;
import my.ipleiria.playxchange.adapters.FaturaAdapter;
import my.ipleiria.playxchange.listeners.FaturasListener;
import my.ipleiria.playxchange.models.Fatura;
import my.ipleiria.playxchange.models.SingletonLoja;
import my.ipleiria.playxchange.utils.Constants;


public class FaturaFragment extends Fragment implements FaturasListener {

    private ListView lvFaturas;


    public FaturaFragment() {

    }

    @Override
    public void onCreate(Bundle savedInstanceState) {
      super.onCreate(savedInstanceState);
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_fatura, container, false);
        lvFaturas = view.findViewById(R.id.lvFaturas);
        SharedPreferences sharedPreferences = getContext().getSharedPreferences(Constants.CURRENT_USER, Context.MODE_PRIVATE);
        String token = sharedPreferences.getString(Constants.TOKEN, null);
        SingletonLoja.getInstance(getContext()).setFaturasListener(this);
        SingletonLoja.getInstance(getContext()).getFaturasAPI(getContext(), token);

        return view;
    }

    @Override
    public void onRefreshListaFaturas(ArrayList<Fatura> listaFaturas) {
        if (listaFaturas == null || listaFaturas.isEmpty()) {
            Toast.makeText(getContext(), "Sem faturas", Toast.LENGTH_SHORT).show();
        }else{
            FaturaAdapter adapter = new FaturaAdapter(getContext(), listaFaturas);
            lvFaturas.setAdapter(adapter);
        }
    }



}