package my.ipleiria.playxchange.fragments;

import android.content.Intent;
import android.os.Bundle;

import androidx.fragment.app.Fragment;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.GridView;
import android.widget.Toast;

import java.util.ArrayList;

import my.ipleiria.playxchange.GameDetailsActivity;
import my.ipleiria.playxchange.R;
import my.ipleiria.playxchange.adapters.JogosAdapter;
import my.ipleiria.playxchange.listeners.JogosListener;
import my.ipleiria.playxchange.models.Jogo;
import my.ipleiria.playxchange.models.SingletonLoja;


public class JogosFragment extends Fragment implements JogosListener {

    GridView gvJogos;


    public JogosFragment() {
        // Required empty public constructor
    }


    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_jogos, container, false);
        gvJogos = view.findViewById(R.id.gvJogos);

        SingletonLoja.getInstance(getContext()).setJogosListener(this);
        SingletonLoja.getInstance(getContext()).getJogosAPI(getContext());

        return view;
    }

    @Override
    public void onRefreshListaJogos(ArrayList<Jogo> jogos) {
        gvJogos.setAdapter(new JogosAdapter(jogos,getContext()));
        gvJogos.setOnItemClickListener((parent, view, position, id) -> {
           if(jogos.get(position).getId() != 0) {
               openGameDetails(jogos.get(position).getId());
           }else {
               Toast.makeText(getContext(), "Jogo não encontrado", Toast.LENGTH_SHORT).show();
           }
        });
    }

    @Override
    public void onRefreshListaJogosRecentes(ArrayList<Jogo> jogos) {

    }

    @Override
    public void onRefreshListaJogosPopulares(ArrayList<Jogo> jogos) {

    }

    private void openGameDetails(int id) {
        Intent intent = new Intent(getContext(), GameDetailsActivity.class);
        intent.putExtra("ID_JOGO", id);
        startActivity(intent);
    }
}