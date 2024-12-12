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

import java.util.ArrayList;
import java.util.List;

import my.ipleiria.playxchange.R;
import my.ipleiria.playxchange.adapters.FaturaAdapter;
import my.ipleiria.playxchange.models.Fatura;
import my.ipleiria.playxchange.models.SingletonLoja;
import my.ipleiria.playxchange.utils.Constants;


public class FaturaFragment extends Fragment {

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
        SingletonLoja.getInstance(getContext()).getFaturasAPI(getContext(), token, new Response.Listener<ArrayList<Fatura>>() {
            @Override
            public void onResponse(ArrayList<Fatura> response) {
                if (response == null || response.isEmpty()) {
                    Toast.makeText(getContext(), "Sem faturas", Toast.LENGTH_SHORT).show();
                    return;
                }
                FaturaAdapter adapter = new FaturaAdapter(getContext(), response);
                lvFaturas.setAdapter(adapter);
            }

        });

        return view;
    }
}