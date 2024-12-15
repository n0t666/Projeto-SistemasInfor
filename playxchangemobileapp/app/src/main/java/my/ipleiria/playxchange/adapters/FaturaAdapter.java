package my.ipleiria.playxchange.adapters;

import android.content.Context;
import android.content.Intent;
import android.graphics.drawable.GradientDrawable;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;

import androidx.core.content.ContextCompat;

import com.bumptech.glide.Glide;
import com.google.android.material.button.MaterialButton;
import com.google.android.material.textview.MaterialTextView;

import java.util.ArrayList;

import my.ipleiria.playxchange.FaturaDetailsActivity;
import my.ipleiria.playxchange.R;
import my.ipleiria.playxchange.models.Fatura;


public class FaturaAdapter extends BaseAdapter {

    private Context context;
    private LayoutInflater inflater;
    private ArrayList<Fatura> faturas;

    public FaturaAdapter(Context context, ArrayList<Fatura> faturas) {
        this.context = context;
        this.faturas = faturas;
    }

    @Override
    public int getCount() {
        return faturas.size();
    }

    @Override
    public Object getItem(int position) {
        return faturas.get(position);
    }

    @Override
    public long getItemId(int position) {
        return faturas.get(position).getId();
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        if(inflater == null){
            inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        }

        if(convertView == null){
            convertView = inflater.inflate(R.layout.fatura_item, null);
        }

      ViewHolderList viewHolder = (ViewHolderList) convertView.getTag();
        if (viewHolder == null){
            viewHolder = new ViewHolderList(convertView);
            convertView.setTag(viewHolder);
        }

        viewHolder.update(faturas.get(position));
        return convertView;
    }

    private class ViewHolderList {
        private MaterialTextView tvTotalPreco,tvStatus,tvTotalQuantidade;
        MaterialButton btnVerDetalhes;
        ImageView[] ivImagens = {null, null, null, null};
        View vStatus;

        public ViewHolderList(View view){
            tvTotalPreco = view.findViewById(R.id.tvTotalPreco);
            tvStatus = view.findViewById(R.id.tvStatus);
            tvTotalQuantidade = view.findViewById(R.id.tvTotalItens);
            btnVerDetalhes = view.findViewById(R.id.btnView);
            ivImagens[0] = view.findViewById(R.id.ivCover1);
            ivImagens[1] = view.findViewById(R.id.ivCover2);
            ivImagens[2] = view.findViewById(R.id.ivCover3);
            ivImagens[3] = view.findViewById(R.id.ivCover4);
            vStatus = view.findViewById(R.id.vStatus);
        }

        public void update(Fatura fatura){
            tvTotalPreco.setText(String.format("%.2f€", fatura.getTotal()));
            tvStatus.setText(fatura.getEstado().getEstadoNome());
            tvTotalQuantidade.setText("(" + String.valueOf(fatura.getTotalItens()) + " itens)");
            for(int i = 0; i < 4; i++) {
                if (i < fatura.getCapasPreview().size()) { //se existir imagem no determinado indice
                    Glide.with(context).load(fatura.getCapasPreview().get(i)).into(ivImagens[i]);
                } else {
                    ivImagens[i].setVisibility(View.INVISIBLE); //se não existir imagem, tornar invisivel mas ocupar espaço na mesma no layout
                }
            }
            // Não será possível pois faz override no background inteiro
            //vStatus.setBackgroundColor(fatura.getEstado().getCor());
            GradientDrawable drawable = (GradientDrawable) vStatus.getBackground();
            int strokeColor = ContextCompat.getColor(context, fatura.getEstado().getCor()); //cor do estado
            drawable.setStroke(5, strokeColor); // definir a espessura e a cor do do circulo sem preenchimento

            btnVerDetalhes.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    Intent intent = new Intent(context, FaturaDetailsActivity.class);
                    intent.putExtra("ID_FATURA", fatura.getId());
                    context.startActivity(intent);
                }
            });

        }
    }


}


