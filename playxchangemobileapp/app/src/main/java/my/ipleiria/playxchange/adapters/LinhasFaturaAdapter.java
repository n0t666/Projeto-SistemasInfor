package my.ipleiria.playxchange.adapters;

import android.content.Context;
import android.content.Intent;
import android.graphics.drawable.GradientDrawable;
import android.view.ContextThemeWrapper;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.LinearLayout;

import androidx.core.content.ContextCompat;

import com.bumptech.glide.Glide;
import com.bumptech.glide.load.engine.DiskCacheStrategy;
import com.google.android.material.button.MaterialButton;
import com.google.android.material.textview.MaterialTextView;

import java.util.ArrayList;

import my.ipleiria.playxchange.FaturaDetailsActivity;
import my.ipleiria.playxchange.R;
import my.ipleiria.playxchange.models.Fatura;

public class LinhasFaturaAdapter extends BaseAdapter {

    private Context context;
    private LayoutInflater inflater;
    private ArrayList<Fatura.LinhaFatura> linhas;


    public LinhasFaturaAdapter(Context context, ArrayList<Fatura.LinhaFatura> linhas) {
        this.context = context;
        this.linhas = linhas;
    }
    @Override
    public int getCount() {
        return linhas.size();
    }

    @Override
    public Object getItem(int position) {
        return linhas.get(position);
    }

    @Override
    public long getItemId(int position) {
        return linhas.get(position).getIdJogo();
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        if(inflater == null){
            inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        }

        if(convertView == null){
            convertView = inflater.inflate(R.layout.fatura_detail_item, null);
        }

        LinhasFaturaAdapter.ViewHolderList viewHolder = (LinhasFaturaAdapter.ViewHolderList) convertView.getTag();
        if (viewHolder == null){
            viewHolder = new LinhasFaturaAdapter.ViewHolderList(convertView);
            convertView.setTag(viewHolder);
        }

        viewHolder.update(linhas.get(position));
        return convertView;
    }

    private class ViewHolderList {
        private ImageView ivCapa;
        private MaterialTextView tvPlataforma,tvPrecoUnitario,tvQuantidade,tvSubtotal;
        private LinearLayout llChaves;


        public ViewHolderList(View view){
            ivCapa = view.findViewById(R.id.ivCapa);
            tvPlataforma = view.findViewById(R.id.tvPlataforma);
            tvPrecoUnitario = view.findViewById(R.id.tvPrecoUnit);
            tvQuantidade = view.findViewById(R.id.tvQuant);
            tvSubtotal = view.findViewById(R.id.tvSubtotal);
            llChaves = view.findViewById(R.id.llChaves);

        }

        public void update(Fatura.LinhaFatura linha){
            Glide.with(context)
                    .load(linha.getImagem())
                    .placeholder(R.drawable.placeholder_jogo)
                    .diskCacheStrategy(DiskCacheStrategy.ALL)
                    .into(ivCapa);
            tvPlataforma.append(" " + linha.getPlataforma());
            tvPrecoUnitario.append(" " + String.format("%.2f",linha.getPreco()) + "€");
            tvQuantidade.append(" " +String.valueOf(linha.getQuantidade()));
            tvSubtotal.append(" " + String.format("%.2f",linha.getSubtotal()) + "€");
            for(String chave : linha.getChaves()){
                MaterialTextView tvChave = new MaterialTextView(context);
                tvChave.setTextAppearance(context, R.style.ChavesTextView);
                tvChave.setText(chave);
                llChaves.addView(tvChave);
            }



        }
    }
}
