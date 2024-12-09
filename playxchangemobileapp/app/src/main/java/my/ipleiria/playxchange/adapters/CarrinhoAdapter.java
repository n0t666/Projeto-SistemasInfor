package my.ipleiria.playxchange.adapters;

import android.content.Context;
import android.content.SharedPreferences;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.TextView;

import com.bumptech.glide.Glide;
import com.bumptech.glide.load.engine.DiskCacheStrategy;

import java.util.ArrayList;
import java.util.List;

import my.ipleiria.playxchange.R;
import my.ipleiria.playxchange.models.Carrinho;
import my.ipleiria.playxchange.models.LinhaCarrinho;
import my.ipleiria.playxchange.utils.Constants;

public class CarrinhoAdapter extends BaseAdapter {
    private Context context;
    private LayoutInflater inflater;
    private List<LinhaCarrinho> linhas;

    public CarrinhoAdapter(Context context, List<LinhaCarrinho> linhas) {
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
        return linhas.get(position).getId();
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        if (inflater == null){
            inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        }

        if (convertView == null){
            convertView = inflater.inflate(R.layout.carrinho_item, null);
        }

        ViewHolderList viewHolder = (ViewHolderList) convertView.getTag();
        if (viewHolder == null){
            viewHolder = new ViewHolderList(convertView);
            convertView.setTag(viewHolder);
        }

        viewHolder.update(linhas.get(position));
        return convertView;


    }

    private class ViewHolderList{
        private TextView tvNome, tvPreco, tvQuantidade,tvPlataforma;
        private ImageView ivCapa,ivDelete;
        private Button  btnDec, btnInc;

        public ViewHolderList(View view){
            tvNome = view.findViewById(R.id.tvNome);
            tvPreco = view.findViewById(R.id.tvPreco);
            tvQuantidade = view.findViewById(R.id.tvQuant);
            tvPlataforma = view.findViewById(R.id.tvPlataforma);
            ivCapa = view.findViewById(R.id.ivCapa);
            ivDelete = view.findViewById(R.id.ivDelete);
            btnDec = view.findViewById(R.id.btnDec);
            btnInc = view.findViewById(R.id.btnInc);
        }

        public void update(LinhaCarrinho linha){
            tvNome.setText(linha.getNome());
            tvPreco.setText(String.format("€%.2f", linha.getPreco()));
            tvQuantidade.setText(String.valueOf(linha.getQuantidade()));
            tvPlataforma.setText(linha.getPlataforma());

            Glide.with(context)
                    .load(linha.getImagem())
                    .diskCacheStrategy(DiskCacheStrategy.ALL)
                    .into(ivCapa);

            ivDelete.setOnClickListener(v -> {

            });

            btnDec.setOnClickListener(v -> {


            });

            btnInc.setOnClickListener(v -> {


            });


        }

    }
}
