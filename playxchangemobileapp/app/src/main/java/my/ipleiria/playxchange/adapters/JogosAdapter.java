package my.ipleiria.playxchange.adapters;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;

import com.bumptech.glide.Glide;
import com.bumptech.glide.load.engine.DiskCacheStrategy;

import java.lang.reflect.Array;
import java.util.ArrayList;

import my.ipleiria.playxchange.R;
import my.ipleiria.playxchange.models.Jogo;

public class JogosAdapter extends BaseAdapter {

    private Context context;
    private LayoutInflater inflater;
    private ArrayList<Jogo> jogos;

    public JogosAdapter(ArrayList<Jogo> jogos, Context context) {
        this.jogos = jogos;
        this.context = context;
    }

    @Override
    public int getCount() {
        return  jogos.size();
    }

    @Override
    public Object getItem(int position) {
        return jogos.get(position);
    }

    @Override
    public long getItemId(int position) {
        return jogos.get(position).getId();
    }

    @Override
    public View getView(int position, View view, ViewGroup parent) {
        if(inflater == null){
            inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        }

        if(view == null){
            view = inflater.inflate(R.layout.jogo_grid_item, null);
        }
        ViewHolderLista viewHolder = (ViewHolderLista) view.getTag();
        if (viewHolder == null){
            viewHolder = new ViewHolderLista(view);
            view.setTag(viewHolder);
        }
        viewHolder.update(jogos.get(position));
        return view;
    }
    private class ViewHolderLista{

        private ImageView ivCapa;


        public ViewHolderLista(View view){
            ivCapa = view.findViewById(R.id.ivJogoPoster);
        }

        public void update(Jogo jogo){
            Glide.with(context)
                    .load(jogo.getCapas())
                    .placeholder(R.drawable.placeholder_jogo)
                    .diskCacheStrategy(DiskCacheStrategy.ALL)
                    .into(ivCapa);
        }
    }

}
